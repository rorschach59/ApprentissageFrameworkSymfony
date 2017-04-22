<?php
// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{

  // public function indexAction()
  // {
  //   $content = $this->get('templating')->render('OCPlatformBundle:Advert:index.html.twig');
  //
  //   return new Response($content);
  // }

  public function indexAction($page)
  {
    // On ne sait pas combien de pages il y a
    // Mais on sait qu'une page doit être supérieure ou égale à 1
    if ($page < 1) {
      // On déclenche une exception NotFoundHttpException, cela va afficher
      // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    // Notre liste d'annonce en dur
    $listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime())
    );

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts
    ));

  }

// La route fait appel à OCPlatformBundle:Advert:view on doit donc définir la méthode viewAction.
// On donne à cette méthode l'argument $id, pour correspondre au paramètre {id} de la route
// public function viewAction($id)
// {
//   // http://localhost/Framework-Symfony/web/app_dev.php/platform/advert/5
//   // $id vaut 5 si l'on a appelé l'URL /platform/advert/5
//
//   // Ici, on récupèrera depuis la base de données l'annonce correspondant à l'id $id.
//   // Puis on passera l'annonce à la vue pour qu'elle puisse l'afficher
//
//   return new Response("Affichage de l'annonce d'id : ".$id);
// }

// // On injecte la requête dans les arguments de la méthode, pour utiliser Request ne pas oublier de use le request plus haut
// public function viewAction($id, Request $request)
// {
//   // On récupère notre paramètre tag
//   $tag = $request->query->get('tag');
//
//   return new Response(
//     "Affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag
//   );
// }

  // public function viewAction($id)
  // {
  //   return new JsonResponse(array('id' => $id));
  // }

  // public function viewAction($id, Request $request)
  // {
  //
  //   // On récupère notre paramètre tag
  //   $tag = $request->query->get('tag');
  //
  //   // Récupére la view view.html.twig
  //   return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
  //     'id'  => $id,
  //     'tag' => $tag,
  //   ));
  // }

  public function viewAction($id)
    {
      $advert = array(
        'title'   => 'Recherche développpeur Symfony2',
        'id'      => $id,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()
      );

      return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
        'advert' => $advert
      ));
    }

  // Redirige l'utilisateur grâce à redirectToRoute();
  public function redirectAction()
  {
    return $this->redirectToRoute('oc_platform_home');
  }

  // On récupère tous les paramètres en arguments de la méthode
  public function viewSlugAction($slug, $year, $_format)
  {
      return new Response(
        // http://localhost/Framework-Symfony/web/app_dev.php/platform/2011/webmaster-aguerri.html
          "On pourrait afficher l'annonce correspondant au
          slug '".$slug."', créée en ".$year." et au format ".$_format."."
      );
  }

  public function addAction(Request $request)
  {
    $session = $request->getSession();

    // Bien sûr, cette méthode devra réellement ajouter l'annonce

    // Mais faisons comme si c'était le cas
    $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

    // Le « flashBag » est ce qui contient les messages flash dans la session
    // Il peut bien sûr contenir plusieurs messages :
    $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');

    // Puis on redirige vers la page de visualisation de cette annonce
    // return $this->redirectToRoute('oc_platform_view', array('id' => 5));
    return $this->render('OCPlatformBundle:Advert:add.html.twig');
    
  }

  public function editAction($id, Request $request)
  {
    // ...

    $advert = array(
      'title'   => 'Recherche développpeur Symfony',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  }

  public function deleteAction($id, Request $request)
  {
    // ...

    $advert = array(
      'title'   => 'Recherche développpeur Symfony',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
      'advert' => $advert
    ));
  }

  public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }

}
