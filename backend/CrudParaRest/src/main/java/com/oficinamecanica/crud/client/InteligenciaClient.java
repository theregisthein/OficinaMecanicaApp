package com.oficinamecanica.crud.client;

import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;

@Component
public class InteligenciaClient {
    private final RestTemplate restTemplate = new RestTemplate();
    private final String URI = "http://localhost:9090/ia/gerar-relatorio";

    public String solicitarRelatorio() {
        // Como é um POST sem corpo (o corpo é gerado lá dentro), mandamos null
        return restTemplate.postForObject(URI, null, String.class);
    }
}