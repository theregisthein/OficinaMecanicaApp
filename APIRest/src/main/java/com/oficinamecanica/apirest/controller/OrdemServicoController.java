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

import com.oficinamecanica.apirest.entity.OrdemServico;
import com.oficinamecanica.apirest.service.OrdemServicoService;

@RestController
public class OrdemServicoController {
    
    @Autowired
    OrdemServicoService servOrdemServico;

    @PostMapping("/ordemServico")
    public OrdemServico save(@RequestBody OrdemServico ordServ) {
        servOrdemServico.save(ordServ);
        return ordServ;
    }

    @GetMapping("/ordemServico")
    public List<OrdemServico> list() {
        return servOrdemServico.findAll();
    }

    @PutMapping("/ordemServico")
    public OrdemServico update(@RequestBody OrdemServico ordServ){
      servOrdemServico.save(ordServ);
      return ordServ;
    }

    @DeleteMapping("/ordemServico/{id}")
    public Optional<OrdemServico> delete(@PathVariable Long id){
      Optional<OrdemServico> os = servOrdemServico.findById(id);
      servOrdemServico.delete(os.get());
      return os;
    }

    @GetMapping("/ordemServico/{numero}")
    public Optional<OrdemServico> read(@PathVariable Long numero){
      Optional<OrdemServico> os = servOrdemServico.findById(numero);
      return os;
    }


    









}
