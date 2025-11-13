package com.oficinamecanica.crud.client;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.Pessoa;

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

  
  public void inserir(Pessoa pe) {
    try {
        URI uri = new URI("http://localhost:9090/pessoa");
        restTemplate.postForObject(uri, pe, Pessoa.class);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void atualizar(Pessoa pe) {
    try {
        restTemplate.put(uri, pe);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void excluir(Integer id) {
    try {
        restTemplate.delete(uri + "/" + id);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }








}
