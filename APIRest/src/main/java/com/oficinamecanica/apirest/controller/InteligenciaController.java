package com.oficinamecanica.apirest.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.apirest.service.DataAggregationService;
import com.oficinamecanica.apirest.service.GeminiService;

@RestController
@RequestMapping("/ia")
@CrossOrigin(origins = "*")
public class InteligenciaController {

    @Autowired
    private DataAggregationService dataService;

    @Autowired
    private GeminiService geminiService;

    @PostMapping("/gerar-relatorio")
    public String gerarRelatorio() {
        try {
            // 1. Busca TODOS os dados do banco (Pessoas, Veiculos, OS, Itens)
            String jsonDados = dataService.gerarJsonCompleto();

            // 2. Cria o Prompt Fixo
            String prompt = "Aja como um gerente de oficina mecânica experiente.\n"
                + "Analise os dados JSON abaixo (que contêm clientes, veículos e ordens de serviço).\n\n"
                + "Gere um relatório resumido citando:\n"
                + "1. Faturamento total (soma dos itens das OS).\n"
                + "2. Quais clientes gastaram mais.\n"
                + "3. Veículos com mais manutenções.\n\n"
                + "Seja direto, use formatação HTML simples (negrito, listas) para eu exibir no site.\n"
                + "Dados:\n"
                + "```json\n"
                + jsonDados
                + "\n```";

            // 3. Manda para a IA e retorna a resposta
            return geminiService.enviarPrompt(prompt);

        } catch (Exception e) {
            e.printStackTrace();
            return "Erro ao gerar relatório com IA: " + e.getMessage();
        }
    }
}