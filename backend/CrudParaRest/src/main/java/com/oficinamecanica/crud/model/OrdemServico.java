package com.oficinamecanica.crud.model;

import java.util.List;

public class OrdemServico {

    private Long id;
    private Long cliente_id;
    private Long veiculo_id;
    private String data_emissao;
    private String status;

    //lista de "filhos"
    // o nome "itens" deve bater com o JSON que o laravel vai enviar
    private List<OS_Item> itens;

    public OrdemServico() {
    }

    public Long getId() {
        return id;
    }
    public void setId(Long id) {
        this.id = id;
    }

    public Long getCliente_id() {
        return cliente_id;
    }
    public void setCliente_id(Long cliente_id) {
        this.cliente_id = cliente_id;
    }

    public Long getVeiculo_id() {
        return veiculo_id;
    }
    public void setVeiculo_id(Long veiculo_id) {
        this.veiculo_id = veiculo_id;
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

    // 3. Getter/Setter para a lista de "filhos"
    public List<OS_Item> getItens() {
        return itens;
    }
    public void setItens(List<OS_Item> itens) {
        this.itens = itens;
    }
}