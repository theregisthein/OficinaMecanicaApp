package com.oficinamecanica.apirest.entity;

import com.fasterxml.jackson.annotation.JsonIgnore;

import jakarta.persistence.Entity;
import jakarta.persistence.FetchType;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.Table;

@Entity
@Table(name = "ordem_item") 
public class OS_Item {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private Long item_id;
    private Double quantidade;
    private Double valor_unitario;
    private Double valor_total; 

    
    // isso quebra o loop infinito do JSON
    @JsonIgnore 
    @ManyToOne(fetch = FetchType.LAZY) // O relacionamento com a mae
    @JoinColumn(name = "ordem_id")
    private OrdemServico ordemServico;

// "Loop Infinito" do JSON
//O Java tenta converter a OrdemServico (mae) em JSON
//Ele encontra a List<OS_Item> (os filhos) e começa a converter o primeiro filho
//Ele encontra no Filho a referencia de volta para a OrdemServico (a Mae)
//Ele tenta converter a Mãe que tem uma lista de Filhos que tem uma Mãe (Loop Infinito)
//O Java quebra com um erro (StackOverflowError) e retorna 500
//O Laravel ve o 500 e mostra a lista vazia.


    public OS_Item() {
    
    }


    public Long getId() {
        return id;
    }
    public void setId(Long id) {
        this.id = id;
    }

    public Long getItem_id() {
        return item_id;
    }
    public void setItem_id(Long item_id) {
        this.item_id = item_id;
    }

    public Double getQuantidade() {
        return quantidade;
    }
    public void setQuantidade(Double quantidade) {
        this.quantidade = quantidade;
    }

    public Double getValor_unitario() {
        return valor_unitario;
    }
    public void setValor_unitario(Double valor_unitario) {
        this.valor_unitario = valor_unitario;
    }
    
    public Double getValor_total() {
        return valor_total;
    }
    public void setValor_total(Double valor_total) {
        this.valor_total = valor_total;
    }
    
    public OrdemServico getOrdemServico() {
        return ordemServico;
    }
    public void setOrdemServico(OrdemServico ordemServico) {
        this.ordemServico = ordemServico;
    }
}