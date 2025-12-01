package com.oficinamecanica.crud.model;


public class OS_Item {
    
    private Long id;
    private Item item;
    private Double quantidade;
    private Double valor_unitario;
    private Double valor_total;

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