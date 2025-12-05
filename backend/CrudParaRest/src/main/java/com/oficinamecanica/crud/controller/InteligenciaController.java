package com.oficinamecanica.crud.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.crud.client.InteligenciaClient;

@RestController
@RequestMapping("/ia-proxy")
@CrossOrigin(origins = "*")
public class InteligenciaController {

    @Autowired
    private InteligenciaClient iaClient;

    @PostMapping("/gerar")
    public ResponseEntity<String> gerar() {
        String resposta = iaClient.solicitarRelatorio();
        return ResponseEntity.ok(resposta);
    }
}