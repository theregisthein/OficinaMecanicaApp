package com.oficinamecanica.apirest.controller;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.apirest.entity.Pessoa;
import com.oficinamecanica.apirest.service.PessoaService;

@RestController
public class PessoaController {
    
    @Autowired
    PessoaService servPessoa;

    @PostMapping("/pessoa")
    public Pessoa save(@RequestBody Pessoa pe) {
        servPessoa.save(pe);
        return pe;
    }

    @GetMapping("/pessoa")
    public List<Pessoa> list() {
        return servPessoa.findAll();
    }

    @PutMapping("/pessoa")
    public Pessoa update(@RequestBody Pessoa pe){
      servPessoa.save(pe);
      return pe;
    }

    @DeleteMapping("/pessoa/{id}")
    public Optional<Pessoa> delete(@PathVariable Long id){
      Optional<Pessoa> p = servPessoa.findById(id);
      servPessoa.delete(p.get());
      return p;
    }

    @GetMapping("/pessoa/{numero}")
    public Optional<Pessoa> read(@PathVariable Long numero){
      Optional<Pessoa> p = servPessoa.findById(numero);
      return p;
    }


    









}
