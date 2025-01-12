from flask import Flask, request, Response
from lxml import etree
import grpc
import games_pb2
import games_pb2_grpc
import logging

app = Flask(__name__)

# Initialize gRPC client
channel = grpc.insecure_channel('grpc-service:8080')  # Corrected port
stub = games_pb2_grpc.GameServiceStub(channel)

# Configure logging
logging.basicConfig(level=logging.INFO)

@app.route('/soap', methods=['POST'])
def handle_soap():
    try:
        soap_request = request.data
        logging.info(f"Received SOAP request: {soap_request}")

        # Parse SOAP XML
        xml = etree.fromstring(soap_request)
        player = xml.find('.//player').text

        if not player:
            raise ValueError("Player name is missing in the request.")

        # Create gRPC request
        grpc_request = games_pb2.PlayerRequest(player=player)
        grpc_response = stub.GetGamesByPlayer(grpc_request)

        # Build SOAP response
        envelope = etree.Element("{http://schemas.xmlsoap.org/soap/envelope/}Envelope")
        body = etree.SubElement(envelope, "{http://schemas.xmlsoap.org/soap/envelope/}Body")
        response_el = etree.SubElement(body, "GetGamesByPlayerResponse")
        
        for game in grpc_response.games:
            game_el = etree.SubElement(response_el, "Game")
            etree.SubElement(game_el, "id").text = str(game.id)
            etree.SubElement(game_el, "black").text = game.black
            etree.SubElement(game_el, "white").text = game.white
            etree.SubElement(game_el, "winner").text = game.winner
            etree.SubElement(game_el, "moves").text = game.moves
            etree.SubElement(game_el, "created_at").text = game.created_at

        soap_response = etree.tostring(envelope)
        logging.info(f"Sending SOAP response: {soap_response}")
        return Response(soap_response, mimetype='text/xml')

    except grpc.RpcError as e:
        # Handle gRPC errors
        envelope = etree.Element("{http://schemas.xmlsoap.org/soap/envelope/}Envelope")
        body = etree.SubElement(envelope, "{http://schemas.xmlsoap.org/soap/envelope/}Body")
        fault = etree.SubElement(body, "{http://schemas.xmlsoap.org/soap/envelope/}Fault")
        etree.SubElement(fault, "faultcode").text = "soap:Server"
        etree.SubElement(fault, "faultstring").text = f"gRPC Error: {e.details()}"
        soap_response = etree.tostring(envelope)
        logging.error(f"gRPC Error: {soap_response}")
        return Response(soap_response, mimetype='text/xml', status=500)

    except Exception as e:
        # Handle general errors
        envelope = etree.Element("{http://schemas.xmlsoap.org/soap/envelope/}Envelope")
        body = etree.SubElement(envelope, "{http://schemas.xmlsoap.org/soap/envelope/}Body")
        fault = etree.SubElement(body, "{http://schemas.xmlsoap.org/soap/envelope/}Fault")
        etree.SubElement(fault, "faultcode").text = "soap:Client"
        etree.SubElement(fault, "faultstring").text = str(e)
        soap_response = etree.tostring(envelope)
        logging.error(f"General Error: {soap_response}")
        return Response(soap_response, mimetype='text/xml', status=400)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)