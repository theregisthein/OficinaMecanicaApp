package com.oficinamecanica.apirest.service;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import com.oficinamecanica.apirest.entity.OrdemServico;

public interface OrdemServicoService extends JpaRepository<OrdemServico, Long> {

    
    //Busca todas as OS, mas força o "join" para trazer os Itens (filhos)
    //na mesma consulta, evitando o erro de LazyInitialization.
    
    @Query("SELECT os FROM OrdemServico os LEFT JOIN FETCH os.itens")
    List<OrdemServico> findAllComItens();

    @Query("SELECT os FROM OrdemServico os LEFT JOIN FETCH os.itens WHERE os.id = :id")
    Optional<OrdemServico> findByIdComItens(@Param("id") Long id);

    

}