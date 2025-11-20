// package com.oficinamecanica.apirest.service;

// import java.util.HashMap;
// import java.util.List;
// import java.util.Map;

// import org.springframework.beans.factory.annotation.Value;
// import org.springframework.http.HttpEntity;
// import org.springframework.http.HttpHeaders;
// import org.springframework.http.HttpMethod;
// import org.springframework.http.MediaType;
// import org.springframework.http.ResponseEntity;
// import org.springframework.stereotype.Service;
// import org.springframework.web.client.RestTemplate;

// @Service
// public class OpenAiService {

//     @Value("${openai.api.key}")
//     private String openAiApiKey;

//     private final String API_URL = "https://api.openai.com/v1/chat/completions";

//     // -----------------------------------------------
//     // MÉTODO CENTRAL USADO PELO CONTROLLER
//     // -----------------------------------------------
//     public String enviarPrompt(String prompt) {
//         return sendMessage(prompt);
//     }

//     // -----------------------------------------------
//     // MÉTODO QUE CHAMA A API DIRETAMENTE
//     // -----------------------------------------------
//     public String sendMessage(String userMessage) {

//         // Corpo da requisição
//         Map<String, Object> body = new HashMap<>();
//         body.put("model", "gpt-4o-mini");

//         List<Map<String, String>> messages = List.of(
//                 Map.of("role", "system", "content", "Você é um assistente especializado em análise de dados de oficinas mecânicas."),
//                 Map.of("role", "user", "content", userMessage)
//         );

//         body.put("messages", messages);

//         // Headers
//         HttpHeaders headers = new HttpHeaders();
//         headers.setContentType(MediaType.APPLICATION_JSON);
//         headers.setBearerAuth(openAiApiKey);

//         HttpEntity<Map<String, Object>> entity = new HttpEntity<>(body, headers);

//         RestTemplate restTemplate = new RestTemplate();

//         try {
//             ResponseEntity<Map> response = restTemplate.exchange(
//                     API_URL,
//                     HttpMethod.POST,
//                     entity,
//                     Map.class
//             );

//             Map<String, Object> responseBody = response.getBody();

//             if (responseBody == null) {
//                 return "Erro: corpo da resposta veio vazio.";
//             }

//             List<Map<String, Object>> choices = (List<Map<String, Object>>) responseBody.get("choices");

//             if (choices == null || choices.isEmpty()) {
//                 return "Erro: nenhuma escolha retornada pela IA.";
//             }

//             Map<String, Object> message = (Map<String, Object>) choices.get(0).get("message");

//             return message != null ? (String) message.get("content") : "Erro: resposta sem conteúdo.";

//         } catch (Exception e) {
//             e.printStackTrace();
//             return "Erro ao chamar a API da OpenAI: " + e.getMessage();
//         }
//     }
// }
