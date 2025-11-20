package com.oficinamecanica.apirest.entity;

import java.util.List;

import jakarta.persistence.CascadeType;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.OneToMany;
import jakarta.persistence.Table;


@Entity
@Table(name = "ordemservico")
public class OrdemServico {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    
    private Long cliente_id;
    private Long veiculo_id;
    private String data_emissao;
    private String status;

    // O relacionamento com a lista de "filhos"
    @OneToMany(
        mappedBy = "ordemServico", // O nome da variável na classe OS_Item
        cascade = CascadeType.ALL, // Salva/Deleta os filhos junto
        orphanRemoval = true
    )
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

    public List<OS_Item> getItens() {
        return itens;
    }
    public void setItens(List<OS_Item> itens) {
        this.itens = itens;
    }
}