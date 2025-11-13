package com.oficinamecanica.crud.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.crud.client.ItemClient;
import com.oficinamecanica.crud.model.Item;

@RestController
@RequestMapping("/items-proxy") // URL que JS vai chamar
@CrossOrigin(origins = "*") 
public class ItemController {

    @Autowired
    private ItemClient itemClient; 

    @GetMapping
    public List<Item> listarTodos() {
        // controller recebe do JS
        // controller chama o Client
        return itemClient.listar(); 
    }

    @PostMapping
    public ResponseEntity<Void> inserir(@RequestBody Item item) {
        itemClient.inserir(item);
        return ResponseEntity.ok().build();
    }

    @DeleteMapping("/{id}") // Recebe o ID da URL (ex: /items-proxy/5)
    public ResponseEntity<Void> excluir(@PathVariable Long id) {
        // 1. Controller chama o Client
        itemClient.excluir(id); 
        return ResponseEntity.ok().build();
    }
}