package com.oficinamecanica.crud.client;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.OrdemServico;

public class OrdemServicoClient {

    private static final String uri = "http://localhost:9090/ordemServico";
    private final RestTemplate restTemplate;

    public OrdemServicoClient() {
        SimpleClientHttpRequestFactory factory = new SimpleClientHttpRequestFactory();
        factory.setConnectTimeout(5000);
        factory.setReadTimeout(5000);
        this.restTemplate = new RestTemplate(factory);
    }

    public List<OrdemServico> listar() {
      List<OrdemServico> lista = new ArrayList<>();
    
      try {
           URI uri = new URI("http://localhost:9090/ordemServico");
           OrdemServico[] os = restTemplate.getForObject(uri, OrdemServico[].class);
           lista = Arrays.asList(os);
      } catch (URISyntaxException e) {
        e.printStackTrace();
      }
      return lista;
    }

  
    public void inserir(OrdemServico os) {
        try {
            URI uri = new URI("http://localhost:9090/ordemServico");
            restTemplate.postForObject(uri, os, OrdemServico.class);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void atualizar(OrdemServico os) {
        try {
            restTemplate.put(uri, os);
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

