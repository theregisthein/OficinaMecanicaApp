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

import com.oficinamecanica.apirest.entity.Veiculo;
import com.oficinamecanica.apirest.service.VeiculoService;

@RestController
public class VeiculoController {
    
    @Autowired
    VeiculoService servVeiculo;

    @PostMapping("/veiculo")
    public Veiculo save(@RequestBody Veiculo vei) {
        servVeiculo.save(vei);
        return vei;
    }

    @GetMapping("/veiculo")
    public List<Veiculo> list() {
        return servVeiculo.findAll();
    }

    @PutMapping("/veiculo")
    public Veiculo update(@RequestBody Veiculo vei){
      servVeiculo.save(vei);
      return vei;
    }

    @DeleteMapping("/veiculo/{id}")
    public Optional<Veiculo> delete(@PathVariable Long id){
      Optional<Veiculo> v = servVeiculo.findById(id);
      servVeiculo.delete(v.get());
      return v;
    }

    @GetMapping("/veiculo/{numero}")
    public Optional<Veiculo> read(@PathVariable Long numero){
      Optional<Veiculo> v = servVeiculo.findById(numero);
      return v;
    }
}
