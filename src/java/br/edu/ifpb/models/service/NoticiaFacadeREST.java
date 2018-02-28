package br.edu.ifpb.models.service;
import java.util.List;
import javax.ejb.Asynchronous;
import javax.ejb.Stateless;
import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;
import javax.ws.rs.Consumes;
import javax.ws.rs.DELETE;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.PUT;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.container.AsyncResponse;
import javax.ws.rs.container.Suspended;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.Response.Status;

@Stateless
@Path("noticias")
public class NoticiaFacadeREST extends AbstractFacade<Noticia> {

    @PersistenceContext(unitName = "Mini-projeto-04PU")
    private EntityManager em;

    public NoticiaFacadeREST() {
        super(Noticia.class);
    }
    
    @POST
    @Path("criar")
    @Asynchronous
    @Consumes(value = {MediaType.APPLICATION_XML, MediaType.APPLICATION_JSON})
    @Produces(MediaType.APPLICATION_JSON)
   
    public void cria(@Suspended final AsyncResponse asyncResponse, final Noticia entity) {
        asyncResponse.resume(criar(entity));
    }

    private Response criar(Noticia entity) {
        
        try{
            Noticia noticia = super.find(entity.getId());
            if (noticia!=null){
                return Response.status(Status.CONFLICT).build();
                  } else{
                super.create(entity);
            return Response.ok(entity).build();
        }
        } catch (Exception e){
            return Response.status(Status.NOT_FOUND).build();
        }
            
    }  

    @PUT
    @Path("{id}")
    @Consumes({MediaType.APPLICATION_XML, MediaType.APPLICATION_JSON})
    @Produces(MediaType.APPLICATION_JSON)
    public Response edita(@PathParam("id") Integer id, Noticia n) {
        try {
            Noticia news = super.find(id);
            news.setTitulo(n.getTitulo());
            super.edit(news);
            return Response.ok(n).build();
        } catch (Exception e) {
            return Response.status(Status.NOT_FOUND).build();
        }
    }

    @DELETE
    @Path("{id}")
    @Consumes({MediaType.APPLICATION_XML, MediaType.APPLICATION_JSON})
    @Produces(MediaType.APPLICATION_XML)
    public Response remove(final @PathParam("id") Integer id) {
        try {
            Noticia n = super.find(id);
            super.remove(n);
            return Response.ok(n).build();
        } catch (Exception e) {
            return Response.status(Status.NOT_FOUND).build();
        }
        
    }

    @GET
    @Path("buscar")
    @Produces({MediaType.TEXT_HTML})
    public Response busca(@QueryParam("id") Integer id) {
        Noticia n = super.find(id);
        if(n == null) {
            return Response.status(Status.NOT_FOUND).build();
        } else {
            return Response.status(200).entity(
                            "<h2>" + n.getTitulo() + "</h2>"+
                            "<p>" + n.getAutor() + "</p>"+
                            "<p>" + n.getData() + "</p>"+                            
                            "<p>" + n.getConteudo() + "</p>"
                    ).build();
        }
    }

    @Override
    protected EntityManager getEntityManager() {
        return em;
    }

   
}
