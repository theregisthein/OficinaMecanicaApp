package com.oficinamecanica.apirest.entity;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;

@Entity
public class OS_Item {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)

    private Long id;
    private Long ordem_id;
    private Long item_id;
    private float quantidade;
    private float valor_unitario;



    public OS_Item() {
    }


    public OS_Item(Long id, Long ordem_id, Long item_id, float quantidade, float valor_unitario) {
        this.id = id;
        this.ordem_id = ordem_id;
        this.item_id = item_id;
        this.quantidade = quantidade;
        this.valor_unitario = valor_unitario;
    }


    public Long getId() {
        return this.id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Long getOrdem_id() {
        return this.ordem_id;
    }

    public void setOrdem_id(Long ordem_id) {
        this.ordem_id = ordem_id;
    }

    public Long getItem_id() {
        return this.item_id;
    }

    public void setItem_id(Long item_id) {
        this.item_id = item_id;
    }

    public float getQuantidade() {
        return this.quantidade;
    }

    public void setQuantidade(float quantidade) {
        this.quantidade = quantidade;
    }

    public float getValor_unitario() {
        return this.valor_unitario;
    }

    public void setValor_unitario(float valor_unitario) {
        this.valor_unitario = valor_unitario;
    }


}