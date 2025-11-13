package com.oficinamecanica.crud.client;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.Veiculo;

public class VeiculoClient {

    private static final String uri = "http://localhost:9090/veiculo";
    private final RestTemplate restTemplate;

    public VeiculoClient() {
          SimpleClientHttpRequestFactory factory = new SimpleClientHttpRequestFactory();
          factory.setConnectTimeout(5000);
          factory.setReadTimeout(5000);
          this.restTemplate = new RestTemplate(factory);
    }

    public List<Veiculo> listar() {
      List<Veiculo> lista = new ArrayList<>();
    
      try {
           URI uri = new URI("http://localhost:9090/veiculo");
           Veiculo[] v = restTemplate.getForObject(uri, Veiculo[].class);
           lista = Arrays.asList(v);
      } catch (URISyntaxException e) {
        e.printStackTrace();
      }
      return lista;
    }

  
    public void inserir(Veiculo ve) {
        try {
            URI uri = new URI("http://localhost:9090/veiculo");
            restTemplate.postForObject(uri, ve, Veiculo.class);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void atualizar(Veiculo ve) {
        try {
            restTemplate.put(uri, ve);
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
