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

import com.oficinamecanica.crud.client.OrdemServicoClient;
import com.oficinamecanica.crud.model.OrdemServico;

@RestController
@RequestMapping("/ordens-proxy") 
@CrossOrigin(origins = "*")
public class OrdemServicoController {

    @Autowired
    private OrdemServicoClient osClient;

    
    //Rota: GET /ordens-proxy
    //Chamado pelo: index() do Laravel
    
    @GetMapping
    public List<OrdemServico> listarTodos() {
        return osClient.listar(); 
    }

     //Chamado pelo: edit() do Laravel
    @GetMapping("/{id}")
    public ResponseEntity<OrdemServico> buscarPorId(@PathVariable Long id) {
        OrdemServico os = osClient.buscaPorId(id);
        if (os != null) {
            return ResponseEntity.ok(os);
        }
        return ResponseEntity.notFound().build();
    }

    
    //Chamado pelo: store() do Laravel (enviando o JSON)
     
    @PostMapping
    public ResponseEntity<Void> inserir(@RequestBody OrdemServico os) {
        osClient.inserir(os);
        return ResponseEntity.ok().build();
    }

    
    //Chamado pelo: update() do Laravel
    
    @PutMapping("/{id}") 
    public ResponseEntity<Void> atualizar(@PathVariable Long id, @RequestBody OrdemServico os) {
        osClient.atualizar(id, os);
        return ResponseEntity.ok().build();
    }

     //Chamado pelo: destroy() do Laravel
     
    @DeleteMapping("/{id}") 
    public ResponseEntity<Void> excluir(@PathVariable Long id) {
        osClient.excluir(id); 
        return ResponseEntity.ok().build();
    }
}