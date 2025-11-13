package com.oficinamecanica.crud.model;

public class Item {
    private Integer id;
    private String nome;
    private String marca;
    private String preco;


    public Item() {
    }

    public Item(Integer id, String nome, String marca, String preco) {
        this.id = id;
        this.nome = nome;
        this.marca = marca;
        this.preco = preco;
    }


    public Integer getId() {
        return this.id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getNome() {
        return this.nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getMarca() {
        return this.marca;
    }

    public void setMarca(String marca) {
        this.marca = marca;
    }

    public String getValor() {
        return this.preco;
    }

    public void setValor(String preco) {
        this.preco = preco;
    }
    
}


