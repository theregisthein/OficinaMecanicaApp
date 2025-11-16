package com.oficinamecanica.crud.client;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.Item;

@Component
public class ItemClient {

  private static final String uri = "http://localhost:9090/item";
  private final RestTemplate restTemplate;

  public ItemClient() {
        SimpleClientHttpRequestFactory factory = new SimpleClientHttpRequestFactory();
        factory.setConnectTimeout(5000);
        factory.setReadTimeout(5000);
        this.restTemplate = new RestTemplate(factory);
  }

  public List<Item> listar() {
    List<Item> lista = new ArrayList<>();
    
    try {
         URI uri = new URI("http://localhost:9090/item");
         Item[] i = restTemplate.getForObject(uri, Item[].class);
         lista = Arrays.asList(i);
    } catch (URISyntaxException e) {
      e.printStackTrace();
    }
    return lista;
  }

  

    public void inserir(Item it) {
    try {
        System.out.println("--- DEBUG CLIENT INSERT: Enviando POST para: " + uri);
        restTemplate.postForObject(uri, it, Item.class);
        System.out.println("--- DEBUG CLIENT INSERT: Sucesso.");
        
    } catch (Exception e) {
        System.out.println("--- ERRO NO CLIENT INSERT: " + e.getMessage());
        e.printStackTrace();
        // ISSO FAZ O ERRO APARECER NO LARAVEL
        throw new RuntimeException("Erro ao INSERIR no client 9090: " + e.getMessage()); 
    }
}

    public void atualizar(Long id, Item it) {
        try {
            String urlDestino = uri; 
         
            // força o ID dentro do objeto mais uma vez
            it.setId(id); 

            restTemplate.put(urlDestino, it);
         
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
            
            // ISSO JOGA O ERRO DE VOLTA PARA O LARAVEL VER
            throw new RuntimeException("Erro ao EXCLUIR no client 9090: " + e.getMessage()); 
        }
    }

    public Item buscaPorId(Long id) {
        try {
            String urlDestino = uri + "/" + id; 
            System.out.println("--- DEBUG CLIENT: Tentando buscar na API 9090: " + urlDestino);
            
            return restTemplate.getForObject(urlDestino, Item.class);
        } catch (Exception e) {
            System.out.println("--- DEBUG CLIENT: Erro ao conectar: " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }








}
