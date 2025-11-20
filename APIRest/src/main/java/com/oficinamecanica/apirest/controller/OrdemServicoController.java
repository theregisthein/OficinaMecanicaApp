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

import com.oficinamecanica.apirest.entity.OS_Item;
import com.oficinamecanica.apirest.entity.OrdemServico;
import com.oficinamecanica.apirest.service.OrdemServicoService;

@RestController
public class OrdemServicoController {
    
    @Autowired
    OrdemServicoService servOrdemServico;

    @PostMapping("/ordemServico")
    public OrdemServico save(@RequestBody OrdemServico ordServ) {
        //  CONEXÃO MÃE-FILHO
        if (ordServ.getItens() != null) {
            for (OS_Item item : ordServ.getItens()) {
                // marca cada filho com a referência da mãe
                item.setOrdemServico(ordServ);
                
                // calcula valor total
                item.setValor_total(item.getQuantidade() * item.getValor_unitario());
            }
        }
        // ------------------------------------

        // Graças ao "CascadeType.ALL", o JPA salva a "Mãe"
        // E TODOS os "Filhos" automaticamente.
        servOrdemServico.save(ordServ);
        
        return ordServ;
    }

    @GetMapping("/ordemServico")
    public List<OrdemServico> list() {
        return servOrdemServico.findAllComItens();
    }

    @PutMapping("/ordemServico")
    public OrdemServico update(@RequestBody OrdemServico ordServ){
        
        if (ordServ.getItens() != null) {
            for (OS_Item item : ordServ.getItens()) {
                // marca cada filho com a referência da mãe
                item.setOrdemServico(ordServ);
                
                item.setValor_total(item.getQuantidade() * item.getValor_unitario());
            }
        }

        // O .save() do JPA é inteligente:
        // Se o 'ordServ' tem ID, ele ATUALIZA (Update)
        // Se não tem ID, ele CRIA (Insert)
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
      Optional<OrdemServico> os = servOrdemServico.findByIdComItens(numero);
      return os;
    }


    









}
