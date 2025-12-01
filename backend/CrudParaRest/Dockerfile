# Usa a imagem oficial do Java (ideal para Spring Boot)
FROM eclipse-temurin:21-jdk-jammy

# Cria o diretório de trabalho no container
WORKDIR /app

# Copia o arquivo JAR já construído para dentro do container
# O comando './gradlew bootJar' ou './mvnw package' deve ser rodado antes de construir a imagem
ARG JAR_FILE=target/*.jar
COPY ${JAR_FILE} app.jar

# Define o comando de execução quando o container for iniciado
ENTRYPOINT ["java", "-jar", "/app/app.jar"]

# Expõe as portas (ex: 9090 para a API, 8080 para o Proxy)
# Você pode remover esta linha se não precisar de acesso direto
# EXPOSE 9090