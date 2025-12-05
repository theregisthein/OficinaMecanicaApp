package com.oficinamecanica.apirest.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.apirest.service.DataAggregationService;
import com.oficinamecanica.apirest.service.OpenAiService;

@RestController
@RequestMapping("/ia")
@CrossOrigin(origins = "*")
public class InteligenciaController {

    @Autowired
    private DataAggregationService dataService;

    @Autowired
    private OpenAiService openAiService;

    @PostMapping("/gerar-relatorio")
    public String gerarRelatorio() {
        try {
            // 1. Busca TODOS os dados do banco (Pessoas, Veiculos, OS, Itens)
            String jsonDados = dataService.gerarJsonCompleto();

            // 2. Cria o Prompt Fixo
            String prompt = "Aja como um gerente de oficina mecânica experiente. "
                    + "Analise os dados JSON abaixo (que contêm clientes, veículos e ordens de serviço). "
                    + "Gere um relatório resumido citando: "
                    + "1. Faturamento total (soma dos itens das OS). "
                    + "2. Quais clientes gastaram mais. "
                    + "3. Veículos com mais manutenções. "
                    + "Seja direto e use formatação simples. Dados: " 
                    + jsonDados;

            // 3. Manda para a IA e retorna a resposta
            return openAiService.enviarPrompt(prompt);

        } catch (Exception e) {
            e.printStackTrace();
            return "Erro ao gerar relatório com IA: " + e.getMessage();
        }
    }
}