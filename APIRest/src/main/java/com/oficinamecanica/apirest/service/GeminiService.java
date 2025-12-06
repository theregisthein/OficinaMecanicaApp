package com.oficinamecanica.apirest.service;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.time.Duration;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import com.fasterxml.jackson.databind.ObjectMapper;

@Service
public class GeminiService {

    @Value("${gemini.api.key}")
    private String apiKey;

    private final ObjectMapper mapper = new ObjectMapper();
    private final HttpClient client = HttpClient.newBuilder().connectTimeout(Duration.ofSeconds(10)).build();

    public String enviarPrompt(String prompt) {
        try {
            // descobrer qual modelo de IA está disponível na conta
            String modelName = descobrirModeloDisponivel();
            
            if (modelName == null) {
                return "Erro: Nenhum modelo de IA encontrado para esta chave API. Verifique se a API está ativada no Google Cloud.";
            }

            // montar a URL com o modelo descoberto
            String urlFinal = "https://generativelanguage.googleapis.com/v1beta/" + modelName + ":generateContent";
            
            System.out.println("--- USANDO MODELO AUTOMÁTICO: " + modelName + " ---");

            // enviar o Prompt
            return enviarRequisicao(urlFinal, prompt);

        } catch (Exception e) {
            e.printStackTrace();
            return "Erro interno: " + e.getMessage();
        }
    }

    private String descobrirModeloDisponivel() {
        try {
            // URL para listar modelos
            String urlList = "https://generativelanguage.googleapis.com/v1beta/models?key=" + apiKey.trim();
            
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(urlList))
                    .GET()
                    .build();

            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());

            if (response.statusCode() == 200) {
                Map<String, Object> map = mapper.readValue(response.body(), Map.class);
                List<Map<String, Object>> models = (List<Map<String, Object>>) map.get("models");

                if (models != null) {
                    for (Map<String, Object> model : models) {
                        String name = (String) model.get("name"); // Ex: models/gemini-1.5-flash
                        List<String> methods = (List<String>) model.get("supportedGenerationMethods");
                        
                        // pega o primeiro que serve para gerar texto (generateContent)
                        if (methods != null && methods.contains("generateContent")) {
                            return name;
                        }
                    }
                }
            } else {
                System.out.println("Erro ao listar modelos: " + response.body());
            }
        } catch (Exception e) {
            System.out.println("Falha ao buscar modelos: " + e.getMessage());
        }
        return null;
    }

    private String enviarRequisicao(String url, String prompt) throws Exception {
        Map<String, Object> requestBodyMap = new HashMap<>();
        requestBodyMap.put("contents", List.of(Map.of("parts", List.of(Map.of("text", prompt)))));
        String jsonBody = mapper.writeValueAsString(requestBodyMap);

        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(url))
                .header("Content-Type", "application/json")
                .header("x-goog-api-key", apiKey.trim())
                .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
                .build();

        HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());

        if (response.statusCode() == 200) {
            Map<String, Object> responseMap = mapper.readValue(response.body(), Map.class);
            List<Map<String, Object>> candidates = (List<Map<String, Object>>) responseMap.get("candidates");
    
            if (candidates != null && !candidates.isEmpty()) {
                Map<String, Object> contentResponse = (Map<String, Object>) candidates.get(0).get("content");
                List<Map<String, Object>> parts = (List<Map<String, Object>>) contentResponse.get("parts");
                
                String textoBruto = (String) parts.get(0).get("text");
                
                // LIMPEZA DO MARKDOWN
                // Remove ```html, ```json, ou apenas ``` do início e fim
                String textoLimpo = textoBruto
                        .replaceAll("```html", "")
                        .replaceAll("```json", "")
                        .replaceAll("```", "");
                        
                return textoLimpo.trim(); // retorna o HTML puro
            }
        }
        
        return "Erro API Google (" + response.statusCode() + "): " + response.body();
    }
}