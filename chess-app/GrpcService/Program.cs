using GrpcService.Services;

var builder = WebApplication.CreateBuilder(args);

// Register gRPC services
builder.Services.AddGrpc();

var app = builder.Build();

// Map the renamed gRPC service
app.MapGrpcService<GameServiceImpl>();
app.MapGet("/", () => "Use a gRPC client to communicate.");

app.Run();