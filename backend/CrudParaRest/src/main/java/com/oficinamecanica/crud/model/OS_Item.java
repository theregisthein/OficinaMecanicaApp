package com.oficinamecanica.crud.model;

// Este é o DTO (Molde) do Proxy 8080 (sem @Entity)
// Ele espelha o JSON que a API 9090 envia

public class OS_Item {
    private Long id; 
    private Long item_id;
    private float quantidade;
    private Double valor_unitario;
    private Double valor_total; 

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

    public float getQuantidade() {
        return quantidade;
    }
    public void setQuantidade(float quantidade) {
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