package com.oficinamecanica.apirest.entity;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.Table;

@Entity
@Table(name = "OS_Item") 
public class OS_Item {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    // Usar Objeto Item em vez de item_id ---
    // O Laravel vai mandar: item: { id: 1 }
    @ManyToOne
    @JoinColumn(name = "item_id")
    private Item item;

    // Relacionamento com a Mãe (Ordem)
    @ManyToOne
    @JoinColumn(name = "ordem_id")
    @JsonIgnoreProperties("itens") // Evita loop infinito
    private OrdemServico ordemServico;

    private Double quantidade;
    private Double valor_unitario;
    private Double valor_total;

    public OS_Item() { }

    // Getters e Setters
    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Item getItem() {
        return item;
    }

    public void setItem(Item item) {
        this.item = item;
    }

    public OrdemServico getOrdemServico() {
        return ordemServico;
    }
    
    public void setOrdemServico(OrdemServico ordemServico) {
        this.ordemServico = ordemServico;
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
}