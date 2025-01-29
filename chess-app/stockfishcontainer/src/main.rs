use actix_web::{post, web, App, HttpServer, Responder};
use serde::Deserialize;
use reqwest::Client;

#[derive(Deserialize, Debug)]
struct AnalyzeRequest {
    fen: String,
}

#[derive(Deserialize, Debug)]
struct LichessResponse {
    pvs: Vec<Pv>,
}

#[derive(Deserialize, Debug)]
struct Pv {
    cp: Option<i32>,
    mate: Option<i32>,
}

#[post("/analyze")]
async fn analyze_position(req: web::Json<AnalyzeRequest>) -> impl Responder {
    println!("Received request: {:?}", req);

    // Make an HTTP request to the Lichess API
    let client = Client::new();
    let api_url = "https://lichess.org/api/cloud-eval"; // Lichess API URL
    let response = client.get(api_url)
        .query(&[("fen", &req.fen)])
        .send()
        .await
        .expect("Failed to send request")
        .json::<LichessResponse>()
        .await
        .expect("Failed to parse response");

    let score = if let Some(pv) = response.pvs.first() {
        if let Some(cp) = pv.cp {
            format!("Centipawn score: {}", cp)
        } else if let Some(mate) = pv.mate {
            format!("Mate in {}", mate)
        } else {
            "No score available".to_string()
        }
    } else {
        "No analysis available".to_string()
    };

    web::Json(serde_json::json!({
        "score": score
    }))
}

#[actix_web::main]
async fn main() -> std::io::Result<()> {
    HttpServer::new(|| {
        App::new()
            .service(analyze_position)
    })
    .bind("0.0.0.0:9000")?
    .run()
    .await
}