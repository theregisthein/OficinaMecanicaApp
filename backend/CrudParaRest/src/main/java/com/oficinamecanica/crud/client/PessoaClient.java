package com.oficinamecanica.crud.client;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.Pessoa;

@Component
public class PessoaClient {
    

  private static final String uri = "http://localhost:9090/pessoa";
  private final RestTemplate restTemplate;

  public PessoaClient() {
        SimpleClientHttpRequestFactory factory = new SimpleClientHttpRequestFactory();
        factory.setConnectTimeout(5000);
        factory.setReadTimeout(5000);
        this.restTemplate = new RestTemplate(factory);
  }

  public List<Pessoa> listar() {
    List<Pessoa> lista = new ArrayList<>();
    
    try {
         URI uri = new URI("http://localhost:9090/pessoa");
         Pessoa[] p = restTemplate.getForObject(uri, Pessoa[].class);
         lista = Arrays.asList(p);
    } catch (URISyntaxException e) {
      e.printStackTrace();
    }
    return lista;
  }

  
  public void inserir(Pessoa pessoa) {
        try {
            restTemplate.postForObject(uri, pessoa, Pessoa.class);
        } catch (Exception e) {
            e.printStackTrace();
            throw new RuntimeException("Erro ao INSERIR Pessoa no client 9090: " + e.getMessage()); 
        }
    }

    public void atualizar(Long id, Pessoa pessoa) {
        try {
            String urlDestino = uri; 
            pessoa.setId(id);
            restTemplate.put(urlDestino, pessoa);
        } catch (Exception e) {
            e.printStackTrace();
            throw new RuntimeException("Erro ao ATUALIZAR Pessoa no client 9090: " + e.getMessage());
        }
    }

    public void excluir(Long id) {
        try {
            String urlDestino = uri + "/" + id;
            restTemplate.delete(urlDestino);
            
        } catch (Exception e) {
            e.printStackTrace();
            throw new RuntimeException("Erro ao EXCLUIR no client 9090: " + e.getMessage()); 
        }
    }

    public Pessoa buscaPorId(Long id) {
        try {
            String urlDestino = uri + "/" + id;
            return restTemplate.getForObject(urlDestino, Pessoa.class);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public Pessoa login(String email, String senha) {
        try {
            Pessoa loginData = new Pessoa();
            loginData.setEmail(email);
            loginData.setSenha(senha);

            // Chama a API 9090
            return restTemplate.postForObject(uri + "/login", loginData, Pessoa.class);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
    



}
