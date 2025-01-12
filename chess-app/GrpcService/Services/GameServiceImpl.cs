using Grpc.Core;
using Microsoft.Extensions.Logging;
using MySql.Data.MySqlClient;
using System.Collections.Generic;
using System.Threading.Tasks;
using GrpcService.games;

namespace GrpcService.Services
{
    public class GameServiceImpl : GameService.GameServiceBase
    {
        private readonly ILogger<GameServiceImpl> _logger;
        private readonly string _connectionString;

        public GameServiceImpl(ILogger<GameServiceImpl> logger)
        {
            _logger = logger;
            _connectionString = "Server=mysql-db;Database=chess_db;User=username;Password=password;";
        }

        public override async Task<GameListResponse> GetGamesByPlayer(PlayerRequest request, ServerCallContext context)
        {
            var games = new List<Game>();
            using var connection = new MySqlConnection(_connectionString);
            await connection.OpenAsync();
            var command = new MySqlCommand("SELECT * FROM games WHERE black = @player OR white = @player", connection);
            command.Parameters.AddWithValue("@player", request.Player);

            using var reader = await command.ExecuteReaderAsync();
            while (await reader.ReadAsync())
            {
                games.Add(new Game
                {
                    Id = reader.GetInt32(reader.GetOrdinal("id")),
                    Black = reader.GetString(reader.GetOrdinal("black")),
                    White = reader.GetString(reader.GetOrdinal("white")),
                    Winner = reader.GetString(reader.GetOrdinal("winner")),
                    Moves = reader.GetString(reader.GetOrdinal("moves")),
                    CreatedAt = reader.GetDateTime(reader.GetOrdinal("created_at")).ToString("yyyy-MM-dd HH:mm:ss"), // Assigning as string
                });
            }
            return new GameListResponse { Games = { games } };
        }

        public override Task<MoveResponse> GetMoveSuggestion(MoveRequest request, ServerCallContext context)
        {
            var random = new Random();
            var moves = new[] { "e4", "d4", "Nf3", "c4", "g3" };
            var chosenMove = moves[random.Next(moves.Length)];
            var number = random.Next(1, 100);

            return Task.FromResult(new MoveResponse
            {
                Suggestion = $"Move {number} should have been {chosenMove}"
            });
        }
    }
}