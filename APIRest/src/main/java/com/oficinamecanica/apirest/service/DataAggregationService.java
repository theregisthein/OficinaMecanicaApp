// package com.oficinamecanica.apirest.service;

// import java.util.HashMap;
// import java.util.Map;

// import org.springframework.beans.factory.annotation.Autowired;
// import org.springframework.stereotype.Service;

// import com.fasterxml.jackson.databind.ObjectMapper;

// @Service
// public class DataAggregationService {

//     @Autowired private PessoaService pessoaService;
//     @Autowired private VeiculoService veiculoService;
//     @Autowired private OrdemServicoService ordemServicoService;
//     @Autowired private OS_ItemService osItemService;
//     @Autowired private ItemService itemService;

//     private final ObjectMapper mapper = new ObjectMapper();

//     public String gerarJsonCompleto() throws Exception {
//         Map<String, Object> dados = new HashMap<>();

//         dados.put("pessoas", pessoaService.findAll());
//         dados.put("veiculos", veiculoService.findAll());
//         dados.put("ordensServico", ordemServicoService.findAll());
//         dados.put("itensOS", osItemService.findAll());
//         dados.put("itens", itemService.findAll());

//         return mapper.writeValueAsString(dados);
//     }
// }