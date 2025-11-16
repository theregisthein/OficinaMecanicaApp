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

import com.oficinamecanica.crud.client.VeiculoClient;
import com.oficinamecanica.crud.model.Veiculo;

@RestController
@RequestMapping("/veiculos-proxy")
@CrossOrigin(origins = "*")


public class VeiculoController {

    @Autowired
    private VeiculoClient veiculoClient;

    @GetMapping
    public List<Veiculo> listarTodos() {
        return veiculoClient.listar(); 
    }

    @GetMapping("/{id}")
    public ResponseEntity<Veiculo> buscarPorId(@PathVariable Long id) {

        Veiculo veiculo = veiculoClient.buscaPorId(id);
        
        if (veiculo != null) {
            return ResponseEntity.ok(veiculo);
        }
        
        return ResponseEntity.notFound().build();
    }

    @PostMapping
    public ResponseEntity<Void> inserir(@RequestBody Veiculo veiculo) {

        veiculoClient.inserir(veiculo);
        return ResponseEntity.ok().build();
    }

    @PutMapping("/{id}") 
    public ResponseEntity<Void> atualizar(@PathVariable Long id, @RequestBody Veiculo veiculo) {

        veiculo.setId(id); 
        veiculoClient.atualizar(id, veiculo);
        return ResponseEntity.ok().build();
    }


    @DeleteMapping("/{id}") 
    public ResponseEntity<Void> excluir(@PathVariable Long id) {
        veiculoClient.excluir(id); 
        return ResponseEntity.ok().build();
    }

    
}
