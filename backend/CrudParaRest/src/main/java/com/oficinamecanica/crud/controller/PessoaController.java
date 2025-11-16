package com.oficinamecanica.crud.controller;


import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.crud.client.PessoaClient;
import com.oficinamecanica.crud.model.Pessoa;

@RestController
@RequestMapping("/pessoas-proxy")
@CrossOrigin(origins = "*")


public class PessoaController {

    @Autowired
    private PessoaClient pessoaClient;

    @GetMapping
    public List<Pessoa> listarTodos() {
        return pessoaClient.listar(); 
    }

    @GetMapping("/{id}")
    public ResponseEntity<Pessoa> buscarPorId(@PathVariable Long id) {

        Pessoa pessoa = pessoaClient.buscaPorId(id);
        
        if (pessoa != null) {
            return ResponseEntity.ok(pessoa);
        }
        
        return ResponseEntity.notFound().build();
    }

    @PostMapping
    public ResponseEntity<Void> inserir(@RequestBody Pessoa pessoa) {

        pessoaClient.inserir(pessoa);
        return ResponseEntity.ok().build();
    }

    @PutMapping("/{id}") 
    public ResponseEntity<Void> atualizar(@PathVariable Long id, @RequestBody Pessoa pessoa) {

        pessoa.setId(id); 
        pessoaClient.atualizar(id, pessoa);
        return ResponseEntity.ok().build();
    }


    @DeleteMapping("/{id}") 
    public ResponseEntity<Void> excluir(@PathVariable Long id) {
        pessoaClient.excluir(id); 
        return ResponseEntity.ok().build();
    }

    
}
