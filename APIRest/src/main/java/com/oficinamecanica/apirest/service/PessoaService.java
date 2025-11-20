package com.oficinamecanica.apirest.service;

import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;

import com.oficinamecanica.apirest.entity.Pessoa;

public interface PessoaService extends JpaRepository<Pessoa, Long> {

    // metodo  do JPA para login
    Optional<Pessoa> findByEmailAndSenha(String email, String senha);

}