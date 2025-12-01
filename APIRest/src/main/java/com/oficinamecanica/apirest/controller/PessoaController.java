package com.oficinamecanica.apirest.controller;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.apirest.entity.Pessoa;
import com.oficinamecanica.apirest.service.PessoaService;

@RestController
@RequestMapping("/pessoa")
public class PessoaController {
    
    
    @Autowired
    PessoaService servPessoa;

    @PostMapping
    public Pessoa save(@RequestBody Pessoa pe) {
        servPessoa.save(pe);
        return pe;
    }

    @GetMapping
    public List<Pessoa> list() {
        return servPessoa.findAll();
    }

    @PutMapping
    public Pessoa update(@RequestBody Pessoa pe){
      servPessoa.save(pe);
      return pe;
    }

    @DeleteMapping("/{id}")
    public Optional<Pessoa> delete(@PathVariable Long id){
      Optional<Pessoa> p = servPessoa.findById(id);
      servPessoa.delete(p.get());
      return p;
    }

    @GetMapping("/{numero}")
    public Optional<Pessoa> read(@PathVariable Long numero){
      Optional<Pessoa> p = servPessoa.findById(numero);
      return p;
    }

    @PostMapping("/login") // rota filha
    public ResponseEntity<Pessoa> login(@RequestBody Pessoa loginData) {
        
        String emailBusca = loginData.getEmail().toLowerCase().trim();
        String senhaBusca = loginData.getSenha().trim();
        
        // BUSCA JPA DIRETA: Busca no banco por email E senha em texto simples
        Optional<Pessoa> pessoaOpt = servPessoa.findByEmailAndSenha(emailBusca, senhaBusca); 
        
        // Verifica se o usuário foi encontrado com a combinação exata
        if (pessoaOpt.isPresent()) {
            Pessoa pessoa = pessoaOpt.get();
            
            // Verifica o perfil e retorna sucesso
            //if (pessoa.getPerfil().equals("FUNCIONARIO") || pessoa.getPerfil().equals("ADMIN")) {
                return ResponseEntity.ok(pessoa); 
            //} else {
                //return ResponseEntity.status(403).build(); 
            //}
        } else {
            return ResponseEntity.status(401).build();
        }
    }
}