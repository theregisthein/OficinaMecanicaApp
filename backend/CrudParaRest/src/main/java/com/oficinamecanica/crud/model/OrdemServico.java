package com.oficinamecanica.crud.model;

import java.util.List;

public class OrdemServico {

    private Long id;
    private Pessoa cliente;
    private Veiculo veiculo;
    private String data_emissao;
    private String status;
    private List<OS_Item> itens;

    public OrdemServico() {
    }


    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Pessoa getCliente() {
        return cliente;
    }

    public void setCliente(Pessoa cliente) {
        this.cliente = cliente;
    }

    public Veiculo getVeiculo() {
        return veiculo;
    }

    public void setVeiculo(Veiculo veiculo) {
        this.veiculo = veiculo;
    }

    public String getData_emissao() {
        return data_emissao;
    }

    public void setData_emissao(String data_emissao) {
        this.data_emissao = data_emissao;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public List<OS_Item> getItens() {
        return itens;
    }

    public void setItens(List<OS_Item> itens) {
        this.itens = itens;
    }
}