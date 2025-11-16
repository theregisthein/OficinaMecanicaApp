package com.oficinamecanica.crud.client;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.Veiculo;

@Component
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
            restTemplate.postForObject(uri, ve, Veiculo.class);
        
        } catch (Exception e) {
            e.printStackTrace();
            throw new RuntimeException("Erro ao INSERIR no client 9090: " + e.getMessage()); 
        }
    }

    public void atualizar(Long id, Veiculo ve) {
        try {
            String urlDestino = uri; 
         
            ve.setId(id);
            restTemplate.put(urlDestino, ve);
         
        } catch (Exception e) {
            System.out.println("ERRO NO UPDATE: " + e.getMessage());
            e.printStackTrace();
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

    public Veiculo buscaPorId(Long id) {
        try {
            String urlDestino = uri + "/" + id;
            return restTemplate.getForObject(urlDestino, Veiculo.class);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }



}
