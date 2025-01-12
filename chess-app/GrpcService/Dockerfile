# Filepath: /c:/chessApp/cloudtaak_chessapp/chess-app/GrpcService/Dockerfile

# Stage 1: Build
FROM mcr.microsoft.com/dotnet/sdk:8.0 AS build
WORKDIR /src

# Copy the .csproj file and restore dependencies
COPY ["GrpcService.csproj", "./"]
RUN dotnet restore "./GrpcService.csproj"

# Copy the entire project
COPY . ./

# Build the project in Release configuration
RUN dotnet build "./GrpcService.csproj" -c Release -o /app/build

# Stage 2: Publish
FROM build AS publish
RUN dotnet publish "./GrpcService.csproj" -c Release -o /app/publish

# Stage 3: Final Runtime Image
FROM mcr.microsoft.com/dotnet/aspnet:8.0 AS final
WORKDIR /app
COPY --from=publish /app/publish .
EXPOSE 80
ENTRYPOINT ["dotnet", "GrpcService.dll"]