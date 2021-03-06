<?php

namespace App\DataFixtures;

use App\Entity\Historic;
use App\Entity\User;
use App\Entity\Quizz;
use App\Entity\Theme;
use App\Entity\Question;
use App\Entity\Proposition;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
	private $passwordHasher;

	public function __construct(UserPasswordHasherInterface $passwordHasher)
	{
		$this->passwordHasher = $passwordHasher;
	}

	public function load(ObjectManager $manager)
	{
		// $product = new Product();
		// $manager->persist($product);

		// Create Oquizz / Master User
		$oquizzUser = new User();
		$oquizzUser->setLogin("Oquizz")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("oquizz@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$oquizzUser,
				'123456'
			));
		$manager->persist($oquizzUser);
			
		// Create Oquizz / Master User
		$tomUser = new User();
		$tomUser->setLogin("Tom")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("Tom@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$tomUser,
				'123456'
			));
		$manager->persist($tomUser);


		// Create Oquizz / Master User
		$robinUser = new User();
		$robinUser->setLogin("Robin")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("robin@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$robinUser,
				'123456'
			));
		$manager->persist($robinUser);


		// Create Oquizz / Master User
		$corentinUser = new User();
		$corentinUser->setLogin("Corentin")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("corentin@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$corentinUser,
				'123456'
			));
		$manager->persist($corentinUser);


		// Create Oquizz / Master User
		$fanouUser = new User();
		$fanouUser->setLogin("Fanou")
			->setRoles(['ROLE_ADMIN'])
			->setEmail("fanou@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$fanouUser,
				'123456'
			));
		$manager->persist($fanouUser);



		// Create Users
		$users = ["SuperQuizzeur", "Bill.Murray", "Will.Smith"];
		foreach ($users as $user) {
			$userCreate = new User();
			$userCreate->setLogin($user)
			->setEmail($user."@gmail.com")
			->setRoles(['ROLE_USER'])
			->addFriend($oquizzUser)
			->setPassword($this->passwordHasher->hashPassword(
				$userCreate,
				'123456'
			));

			$manager->persist($userCreate);
		}



		// Create Themes
		// 1st Parent Theme : Serie TV
		$parentTheme = new Theme();
		$parentTheme->setName("S??rie TV");
		$parentTheme->setImage("serietv.jpeg");
		
		$manager->persist($parentTheme);

		// second Parent Theme : Serie TV
		$movietheme = new Theme();
		$movietheme->setName("Films");
		$movietheme->setImage("cinema.jpeg");

		$manager->persist($movietheme);

		$randomtheme = new Theme();
		$randomtheme->setName("Random");
		$manager->persist($randomtheme);
		
		
		// Create Children Themes
		$themes = [
			
			// ["Friends", "friends.jpeg"],
			// ["Kaamelott", "kaamelott.jpeg"],
			// ["Scrubs", "scrubs.jpeg"],
			// ["Ann??es8090", "annees8090.png"],
			// ["How i met your mother", "howimetyourmother.jpeg"],
			// ["Personnages", "personnages.jpeg"],
			// ["Cin??ma", "cin??.png"],
			// ["Fixtures", "ladiesman.jpg"]

		];
	//     $manager->persist($parentTheme);
	
		// Create Children Themes
		//  $themes = ["Black Mirror", "Scrubs", "H", "Kaamelott"];
		foreach ($themes as $theme) {
			$childTheme = new Theme;
			$childTheme->setName($theme[0])->setImage($theme[1]);
			
			$manager->persist($childTheme);

			$theme = $theme[0];

			// Create Quizz
			for ($i = 1; $i < 5; $i++) {
				$quizz = new Quizz();
				$quizz->setName("Questionnaire $theme $i");
				$quizz->addTheme($childTheme);
				$quizz->addTheme($parentTheme);
				$quizz->setCreatedBy($oquizzUser);
				
				$manager->persist($quizz);
				
				for ($j = 1; $j < 21; $j++) {
					// Create Question (20 per theme)
					$question = new Question();
					$question->setQuestion("Question n??$j ( $theme )");
					$question->addQuizz($quizz);
					$question->addTheme($childTheme);
					$question->addTheme($parentTheme);
					$question->setCreatedBy($oquizzUser);

					$manager->persist($question);

					for ($k = 1; $k < 5; $k++) {
						// Create Proposition (4 per question)
						$proposition = new Proposition();
						$proposition->setText("Proposition n??$k (Question N?? $j)");
						if ($k == 1) {
							$proposition->setIsValid(true);
						} else {
							$proposition->setIsValid(false);
						}
						$proposition->setQuestion($question);

						$manager->persist($proposition);
					}
				}
			}           
		}
	
		$manager->flush();
				// /!\ Les th??mes doivent ??tre diff??rents de ceux cr??er plus haut (ligne 42) :
				//     Modifier la variable $themes en cons??quence.

				// Friends
				$friends = new Theme();
				$friends->setName("Friends"); // Nom de la s??rie
				$friends->setImage("friends-logo.png");
				$friends->addThemeParent($parentTheme); // Serie TV
				$manager->persist($friends);

				// Kaamelott
				$kaamelott = new Theme();
				$kaamelott->setName("Kaamelott"); // Nom de la s??rie
				$kaamelott->setImage("kaamelott.jpeg");
				$kaamelott->addThemeParent($parentTheme); // Serie TV
				$manager->persist($kaamelott);

				// Scrubs
				$Scrubs = new Theme();
				$Scrubs->setName("Scrubs"); // Nom de la s??rie
				$Scrubs->setImage("scrubs-logo.jpg");
				$Scrubs->addThemeParent($parentTheme); // Serie TV
				$manager->persist($Scrubs);

				// Ann??es 8090
				$Ann??es8090 = new Theme();
				$Ann??es8090->setName("Ann??es 80-90"); // Nom de la s??rie
				$Ann??es8090->setImage("annees8090.png");
				$Ann??es8090->addThemeParent($parentTheme); // Serie TV
				$manager->persist($Ann??es8090);

				// How i met your mother
				$HowIMetYourMother = new Theme();
				$HowIMetYourMother->setName("How I Met Your Mother"); // Nom de la s??rie
				$HowIMetYourMother->setImage("howimetyourmother-logo.jpeg");
				$HowIMetYourMother->addThemeParent($parentTheme); // Serie TV
				$manager->persist($HowIMetYourMother);

				// Personnages
				$Personnages = new Theme();
				$Personnages->setName("Personnages"); // Nom de la s??rie
				$Personnages->setImage("personnages.jpeg");
				$Personnages->addThemeParent($parentTheme); // Serie TV
				$manager->persist($Personnages);

				// Cin??ma
				$cin??ma = new Theme();
				$cin??ma->setName("Cin??ma"); // Nom du quizz
				$cin??ma->setImage("cin??.png");
				$cin??ma->addThemeParent($movietheme); // Cin??ma
				$manager->persist($cin??ma);

				// Demo
				$demo = new Theme();
				$demo->setName("D??mo"); // Nom de la s??rie 
				$demo->setImage("ladiesman.jpg");
				$demo->addThemeParent($parentTheme); // Serie TV
				$manager->persist($demo);
			   
				           // Quizz builder

                // Connaissez-vous Friends ?
                $quizzFriends = new Quizz();
                $quizzFriends->setName("Connaissez-vous Friends ?"); // Titre du Quizz, ?? modifier
                $quizzFriends->setImage("friends.jpeg");
                $quizzFriends->addTheme($friends)->addTheme($parentTheme)->setCreatedBy($tomUser);
                $manager->persist($quizzFriends);

                // Testez-vous sur Friends ?
                $quizzFriends2 = new Quizz();
                $quizzFriends2->setName("Testez-vous sur Friends ?"); // Titre du Quizz, ?? modifier
                $quizzFriends2->setImage("friends-2.jpeg");
                $quizzFriends2->addTheme($friends)->addTheme($parentTheme)->setCreatedBy($tomUser);
                $manager->persist($quizzFriends2);

                // Connaissez-vous Kaamelott ?
                $quizzKaamelott = new Quizz();
                $quizzKaamelott->setName("Connaissez-vous Kaamelott ?");
                $quizzKaamelott->setImage("kaa.png");
                $quizzKaamelott->addTheme($kaamelott)->addTheme($parentTheme)->setCreatedBy($tomUser);
                $manager->persist($quizzKaamelott);

                // Testez-vous sur Kaamelott ?
                $quizzKaamelott2 = new Quizz();
                $quizzKaamelott2->setName("Testez-vous sur Kaamelott ?");
                $quizzKaamelott2->setImage("kaamelott-2.jpg");
                $quizzKaamelott2->addTheme($kaamelott)->addTheme($parentTheme)->setCreatedBy($tomUser);
                $manager->persist($quizzKaamelott2);

                //Connaissez-vous Scrubs ?
                $quizzScrubs = new Quizz();
                $quizzScrubs->setName("Connaissez-vous Scrubs ?");
                $quizzScrubs->setImage("scrubs.jpeg");
                $quizzScrubs->addTheme($Scrubs)->addTheme($parentTheme)->setCreatedBy($fanouUser);
                $manager->persist($quizzScrubs);

                 //Testez-vous sur Scrubs ?
                 $quizzScrubs2 = new Quizz();
                 $quizzScrubs2->setName("Testez-vous sur Scrubs ?");
                 $quizzScrubs2->setImage("scrubs-1.jpg");
                 $quizzScrubs2->addTheme($Scrubs)->addTheme($parentTheme)->setCreatedBy($fanouUser);
                 $manager->persist($quizzScrubs2);

                //Ann??es 8090
                $quizzAnn??es8090 = new Quizz();
                $quizzAnn??es8090->setName("Ann??es8090"); // Titre du Quizz, ?? modifier
                $quizzAnn??es8090->setImage("annees8090-1.jpg");
                $quizzAnn??es8090->addTheme($Ann??es8090)->addTheme($parentTheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzAnn??es8090);

                //Nostalgie 8090
                $quizzNostalgie8090 = new Quizz();
                $quizzNostalgie8090->setName("Ann??es8090"); // Titre du Quizz, ?? modifier
                $quizzNostalgie8090->setImage("annees8090-2.jpg");
                $quizzNostalgie8090->addTheme($Ann??es8090)->addTheme($parentTheme)->setCreatedBy($corentinUser);
                $manager->persist($quizzNostalgie8090);

                // Connaissez vous How i met your mother ?
                $quizzHowIMetYourMother = new Quizz();
                $quizzHowIMetYourMother->setName("Connaissez vous How i met your mother ?"); // Titre du Quizz, ?? modifier
                $quizzHowIMetYourMother->setImage("howimetyourmother.jpeg");
                $quizzHowIMetYourMother->addTheme($HowIMetYourMother)->addTheme($parentTheme)->setCreatedBy($corentinUser);
                $manager->persist($quizzHowIMetYourMother);

                // Testez-vous sur How i met your mother ?
                $quizzHowIMetYourMother2 = new Quizz();
                $quizzHowIMetYourMother2->setName("Testez-vous sur How i met your mother ?"); // Titre du Quizz, ?? modifier
                $quizzHowIMetYourMother2->setImage("howimetyourmother-1.jpeg");
                $quizzHowIMetYourMother2->addTheme($HowIMetYourMother)->addTheme($parentTheme)->setCreatedBy($corentinUser);
                $manager->persist($quizzHowIMetYourMother2);

                // Personnages de s??ries Tv
                $quizzPersonnages = new Quizz();
                $quizzPersonnages->setName("Personnages de s??ries Tv"); // Titre du Quizz, ?? modifier
                $quizzPersonnages->setImage("personnages-1.jpg");
                $quizzPersonnages->addTheme($Personnages)->addTheme($parentTheme)->setCreatedBy($robinUser);
                $manager->persist($quizzPersonnages);

                // Personnages de s??ries
                $quizzPersonnages2 = new Quizz();
                $quizzPersonnages2->setName("Personnages de s??ries"); // Titre du Quizz, ?? modifier
                $quizzPersonnages2->setImage("personnages-2.jpg");
                $quizzPersonnages2->addTheme($Personnages)->addTheme($parentTheme)->setCreatedBy($robinUser);
                $manager->persist($quizzPersonnages2);

                // Cin??ma Divers
                $quizzCin??ma = new Quizz();
                $quizzCin??ma->setName("Cin??ma Divers"); // Titre du Quizz, ?? modifier
                $quizzCin??ma->setImage("cin??.png");
                $quizzCin??ma->addTheme($cin??ma)->addTheme($movietheme)->setCreatedBy($oquizzUser);
                $manager->persist($quizzCin??ma);


                // Cin??ma Vari??
                $quizzCin??ma2 = new Quizz();
                $quizzCin??ma2->setName("Cin??ma Vari??"); // Titre du Quizz, ?? modifier
                $quizzCin??ma2->setImage("cin??ma.jpg");
                $quizzCin??ma2->addTheme($cin??ma)->addTheme($movietheme)->setCreatedBy($tomUser);
                $manager->persist($quizzCin??ma2);

                // Demo
                $quizzDemo = new Quizz();
                $quizzDemo->setName("Demo oQuizz"); // Titre du Quizz, ?? modifier
                $quizzDemo->setImage("ladiesman.jpg");
                $quizzDemo->addTheme($demo)->addTheme($parentTheme)->setCreatedBy($tomUser);
                $manager->persist($quizzDemo);

                // Quizz Connaissez-vous Friends?           

                // 1
                $questionFriends = new Question();
                $questionFriends->setQuestion("Qui prononce les premiers mots de la s??rie ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Monica")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Chandler")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Phoebe")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ross")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 2
                $questionFriends = new Question();
                $questionFriends->setQuestion("Quel est le nom du caf?? o?? ils se retrouvent ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Central Perk")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Central Presk")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Central Bert")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Centrale Perk")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);
        
                // 3
                $questionFriends = new Question();
                $questionFriends->setQuestion("Comment s'appelle le colocataire psychotique de Chandler ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Eddie Menuek")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Eddie Donque")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Elon Musk")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Just Leblanc")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 4
                $questionFriends = new Question();
                $questionFriends->setQuestion("Pour qui Rachel ressort-elle sa tenue de cheerleader ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Joshua")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Jos??")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Joseph")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Gunther")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 5
                $questionFriends = new Question();
                $questionFriends->setQuestion("Comment s'appelle l'homme qui permet ?? Julie d'oublier Ross ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Russ")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("David")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Gavin")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Janice")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 6
                $questionFriends = new Question();
                $questionFriends->setQuestion("Comment s'appelle la grand-m??re de Ross et Monica qui d??c??de dans la premi??re saison ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Althea")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Athena")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mauricette")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Germaine")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 7
                $questionFriends = new Question();
                $questionFriends->setQuestion("Comment se nomment les tripl??s de Frank Jr ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Franck Jr Jr, Leslie et Chandler")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Ross, Rachel et Chandler")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("LeHulk, Lesly et Phoebe Jr")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Alvin, Simon et Th??odore")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 8
                $questionFriends = new Question();
                $questionFriends->setQuestion("Qui aide Ross ?? monter le canap?? ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Rachel et Chandler")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Phoebe et Monica")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Monica et Chandler")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Joey et Monica")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 9
                $questionFriends = new Question();
                $questionFriends->setQuestion("Combien Joey a-t-il de soeurs ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("7")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("8")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("6")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("2")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                // 10
                $questionFriends = new Question();
                $questionFriends->setQuestion("Qu'offre M.Geller ?? Monica pour compenser la perte de ses souvenirs ?");
                $questionFriends->addQuizz($quizzFriends)->addTheme($friends);
                $questionFriends->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends);

                $proposition = new Proposition();
                $proposition->setText("Sa Porsche")->setIsValid(true)->setQuestion($questionFriends);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Sa montre")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une pi??ce de monnaie")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une maison de poup??es")->setIsValid(false)->setQuestion($questionFriends);
                $manager->persist($proposition);
                
                //Testez vous sur Friends
                // 1
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Quel est l'ancien m??tier de Mike ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Avocat")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Comptable")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Developpateur")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Juge")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 2
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Pour quel r??le Estelle appelle-t-elle Joey quand il commence Mac & C.H.E.E.S.E ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Son r??le actuel")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le fr??re de Drake Ramoray")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un boxeur gay")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Serveur dans un bar")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 3
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Combien de fois Ross s'est-il fianc?? ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("2")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("4")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("3")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("1")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 4
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Dans quel jeu t??l??vis?? Joey est-il invit?? ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Pyramide")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Les chiffres et les lettres")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Qui est qui ?")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le juste prix")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 5
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Quel est le m??tier de la m??re de Chandler ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Romanci??re ??rotique")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Meneuse de revue dans un cabaret")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Docteur")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("M??re au foyer")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 6
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Comment se nomment les soeurs de Rachel ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Amy et Jil")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Annie et Jil")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Amy et Karen")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jil et Karine")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 7
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("O?? Chandler est-il mut?? ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Tulsa")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Phoenix")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Atlanta")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Paris")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 8
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Quelle est la plus grande peur de Rachel ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Les poissons")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Les tarentules")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les pigeons")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les balan??oires")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 9
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("De quel acteur Joey doit-il ??tre la doublure de fesses ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Al Pacino")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Marlon Brando")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Robert DeNiro")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Charlton Eston")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                // 10
                $questionFriends2 = new Question();
                $questionFriends2->setQuestion("Qui prononce les derniers mots de la s??rie ?");
                $questionFriends2->addQuizz($quizzFriends2)->addTheme($friends);
                $questionFriends2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionFriends2);

                $proposition = new Proposition();
                $proposition->setText("Chandler")->setIsValid(true)->setQuestion($questionFriends2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Monica")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ross")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rachel")->setIsValid(false)->setQuestion($questionFriends2);
                $manager->persist($proposition);
        


                // Quizz Connaissez-vous Kaamelott?

                // 1
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion(" A cause de son ill??trisme, comment se fait appeler Perceval lors de ses qu??tes ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Provencal le Gaulois")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("S??bastien le Chabal")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jacques Martin")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lorant Deutsh")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 2
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Pourquoi Kaamelott s?????crit avec 2 ???t??? ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Afin que le nom de la s??rie soit correctement prononc??.")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("C'est Perceval qui l'a ??crit la premi??re fois")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ah bon il y a 2 t?")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Euh non ca s'??crit camelotte")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 3
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Quel personnage ne fait pas partie de la Table Ronde ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Le Duc d'Aquitaine")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Perceval")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Bohort")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("L??odagan")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 4
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Comment s???appelle le Royaume de L??odagan ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("La Carm??lide")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("La Carm??lite")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Caramelys")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La Cal??donie")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 5
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Qui a r??alis?? la bande-son de la s??rie ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Alexandre Astier")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("John Williams")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Vianey")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pascal Obispo")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 6
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Pourquoi Gueni??vre a-t-elle peur des oiseaux ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Ils n???ont pas de bras")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Ils n'ont pas de poils")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ils volent")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ils mangent des graines")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 7
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Sous quel pied Arthur est-il marqu?? au fer rouge ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Le droit")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le gauche")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il n'est pas marqu?? au fer")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("C'est pas faux")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 8
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Quel est le nom de la premi??re ??pouse d???Arthur ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Aconia")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Arnica")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cam??lia")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("C??saria")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 9
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Comment se nomme la m??re de Gueni??vre ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Seli")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("M??ne")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Madame L??odagan")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Fran??oise")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // 10
                $questionkaamelott = new Question();
                $questionkaamelott->setQuestion("Quel est le plat national de Kaamelott ?");
                $questionkaamelott->addQuizz($quizzKaamelott)->addTheme($kaamelott);
                $questionkaamelott->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott);

                $proposition = new Proposition();
                $proposition->setText("Le croque monsieur")->setIsValid(true)->setQuestion($questionkaamelott);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le hot dog")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le chili con carne")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La pizza")->setIsValid(false)->setQuestion($questionkaamelott);
                $manager->persist($proposition);

                // Testez-vous sur Kaamelott
                // 1
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Quel est le nom du clan cr??e par Perceval et Karadoc ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Les Semi-croustillants")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Les Sous-croquants")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les Semi-hommes")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les Semis")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 2
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Quelle est la botte secrete de Perceval ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Ouais, c???est pas faux")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("On en a gros")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La gauche")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La droite")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 3
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Comment Perceval appelle-t-il sa grand-m??re ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Nonna")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Mima")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("M??re-Grand")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jocelyne")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 14
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Quel est le vrai nom de La Dame du Lac ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Viviane")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("C??line")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Carmen")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("M??lissa")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 15
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Selon Bohort quel animal est un pr??dateur mortel ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Le faisan")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le lapin")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le papillon")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le loup")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 16
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Qui a fabriqu?? la table ronde ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Breccan")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Ik??a")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("But")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le voisin")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 17
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Bien que pr??tre officiel de Kaamelott quelle est l???autre fonction du p??re Blaise ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Scribe")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Facteur")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Boulanger")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Eboueur")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 18
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Qui est le p??re du Chevalier Gauvain ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Le roi Loth")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("L??odagan")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Karadoc")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Arthur")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 19
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Qui est le grand rival de Merlin ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Elias")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Herv??")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le P??re Blaise")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Tavernier")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // 20
                $questionkaamelott2 = new Question();
                $questionkaamelott2->setQuestion("Afin de le prot??ger de son p??re, Uther Pendragon, Merlin envoie Arthur aupr??s d???une famille adoptive.Quel est le nom du p??re adoptif d???Arthur ?");
                $questionkaamelott2->addQuizz($quizzKaamelott2)->addTheme($kaamelott);
                $questionkaamelott2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionkaamelott2);

                $proposition = new Proposition();
                $proposition->setText("Anton")->setIsValid(true)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Antoine")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Anthony")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mercorius")->setIsValid(false)->setQuestion($questionkaamelott2);
                $manager->persist($proposition);

                // Quizz Connaissez-vous Scrubs?
                
                // 1
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("???J.D??? sont les initiales pour : ");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Jonathan Dorian")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("John Dev")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jules Derne")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Job D??sir??")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 2
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Quelle s??rie a vu Sarah Chalke (Elliot) d??buter ?? la t??l??vision ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Roseanne")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("How i met your mother")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dallas")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 3
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("De quelle mani??re Cox appelle-t-il souvent J.D ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Pr??noms f??minins")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Jean Jacques")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hey !")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Machin")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 4
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment s???appelle le chien de Bob Kelso ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Baxter")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Dexter")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Laxter")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lobster")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 5
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Pour quel ??tablissement J.D quitte-t-il Sacred Heart ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("La Clinique Saint Vincent")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("L'Hotel Dieu")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une clinique v??t??rinaire")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un Hopital Militaire")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 6
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment Turk et J.D ont-ils appel?? leur ???chien??? empaill?? ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Rowdy")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Lechien")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rufus")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Paf")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 7
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Quel acteur le Dr Cox d??teste-t-il le plus ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Hugh Jackman")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Bradd Pitt")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ryan Reynolds")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Clint Eastwood")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 8
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment s???appelle Le Concierge ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Glen Matthews")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Matthew Glenns")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Tommy Janitor")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("On ne le sait pas")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 9
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Avec qui Cox n???aura-t-il jamais le dernier mot tout au long de la s??rie ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("Jordan")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Kelso")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("J.D")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Turk")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // 10
                $questionScrubs = new Question();
                $questionScrubs->setQuestion("Comment s???appelle le groupe de Ted ?");
                $questionScrubs->addQuizz($quizzScrubs)->addTheme($Scrubs);
                $questionScrubs->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs);

                $proposition = new Proposition();
                $proposition->setText("The Worthless Peons")->setIsValid(true)->setQuestion($questionScrubs);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("The Lawyers")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sacred Heart")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Anonymous")->setIsValid(false)->setQuestion($questionScrubs);
                $manager->persist($proposition);

                // Testez-vous sur Scrubs
                // 1
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Quel est le nom de la m??re du fils de J.D. ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Kim Briggs")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Kim Bassinger")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Carla Shiffer")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Stella Wizeman")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 2
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Qui succ??de ?? Kelso dans les 3 premiers ??pisodes de la saison 8 ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Dr Taylor Maddox")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Dr Evelyn Codox")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr Mitchell Ronflex")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lui-m??me")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 3
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Qui J.D appelle-t-il pour venir ?? bout de Neena ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Jordan")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Le Concierge")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Eliott")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sa maman")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 4
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Quel souvenir Kelso a-t-il ramen?? de la guerre du Vietnam ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Un tatouage ???Johnny???")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Son uniforme")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Des cauchemards")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une femme")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 5
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Qui a cr??e la s??rie ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Bill Lawrence")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Chuck Lorre")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Matha Kauffman")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Bil Clinton")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 6
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Combien de saisons compte la s??rie ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("8+1")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("8")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("10")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("6")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 7
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("A quel c??l??bre docteur, Cox rend-il hommage en marchant avec une canne ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Dr Ross")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr Geller")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr Becker")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 8
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("De quel show m??dical Scrubs a-t-il ??t?? consid??r?? comme un pastiche ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Grey's Anatomy")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Urgences")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Resident")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 9
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Quel est le 2eme pr??nom de Cox ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("Ulysse")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Achille")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Steven")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rodney")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                // 10
                $questionScrubs2 = new Question();
                $questionScrubs2->setQuestion("Pourquoi la majorit?? des ??pisodes ont un titre qui commence par un adjectif possessif ?");
                $questionScrubs2->addQuizz($quizzScrubs2)->addTheme($Scrubs);
                $questionScrubs2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionScrubs2);

                $proposition = new Proposition();
                $proposition->setText("La s??rie est le journal intime de J.D")->setIsValid(true)->setQuestion($questionScrubs2);
                $manager->persist($proposition);
                    
                $proposition = new Proposition();
                $proposition->setText("Ils appartiennent ?? l'auteur")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Erreur de traduction")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("A cause de l'??go du sc??nariste")->setIsValid(false)->setQuestion($questionScrubs2);
                $manager->persist($proposition);

                //Quizz Nostalgie 8090
                // 1
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Bayside ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Sauv??s par le gong")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Buffy contre les vampires")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Beverly Hills")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hartley coeurs ?? vif")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                // 2
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Maire de New York ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Spin City")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Seinfield")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("New York Police Judiciaire")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Happy Days")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 3
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Le Centre ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Le Cam??l??on")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("H??l??ne et les Gar??ons")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Prince de Bel-Air")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Buffy contre les vampires")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 4
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Vendeur de chaussures ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Mari??s, deux enfants")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Alf")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sex and the city")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La f??te ?? la maison")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 5
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Homme de m??nage ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Madame est servie")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Navarro")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La vie de Famille")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("7 ?? la maison")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 6
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Moto noire ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Tonnerre M??canique")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Manimal")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("K2000")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 7
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Robot Orange ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Riptide")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Les dessus de Palm Beach")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le rebelle")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 8
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Moustache ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Arabesque")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Code Quantum")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Profiler")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 9
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : L??zards ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("V")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Code Lisa")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ally McBeal")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dynastie")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);


                // 10
                $questionAnn??es8090 = new Question();
                $questionAnn??es8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Chats ?");
                $questionAnn??es8090->addQuizz($quizzAnn??es8090)->addTheme($Ann??es8090);
                $questionAnn??es8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionAnn??es8090);

                $proposition = new Proposition();
                $proposition->setText("Alf")->setIsValid(true)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une nounou d'enfer")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Friends")->setIsValid(false)->setQuestion($questionAnn??es8090);
                $manager->persist($proposition);

                // Nostalgie 8090
                // 1
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Sens ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Hartley coeurs ?? vif")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mac Gyver")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Deux flics ?? Miami")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 2
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Commissariat dans une ??glise ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("21 Jump Street")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Navarro")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Julie Lescaut")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("New York Police Judiciaire")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 3
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Le chevalier et sa monture ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("K2000")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("La croisi??re s'amuse")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Chips")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 4
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : R??v??rend ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("7 ?? la maison")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Seinfield")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Droles de dames")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hulk")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 5
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Couteau suisse ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("MacGyver")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Stargate SG 1")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sliders les mondes parall??les")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 6
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Plan ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("L'agence tout risque")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("L'amour du risque")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Charmed")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Wonder Woman")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 7
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Journal ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("Demain ?? la une")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Rick Hunter")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cosby Show")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 8
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Australie ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("Hartley Coeurs ?? vif")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Le rebelle")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Alere ?? Malibu")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 9
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Guerre du Vietnam ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("L'enfer du devoir")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Manimal")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dawson")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Magnum")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);


                // 10
                $questionNostalgie8090 = new Question();
                $questionNostalgie8090->setQuestion("A quelle s??rie des ann??es 80/90 pensez-vous si on vous dit : Demi Dieu ?");
                $questionNostalgie8090->addQuizz($quizzNostalgie8090)->addTheme($Ann??es8090);
                $questionNostalgie8090->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionNostalgie8090);

                $proposition = new Proposition();
                $proposition->setText("Hercule")->setIsValid(true)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);
                                
                $proposition = new Proposition();
                $proposition->setText("Ulysse 31")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("L'??talon noir")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hulk")->setIsValid(false)->setQuestion($questionNostalgie8090);
                $manager->persist($proposition);

                // Connaissez vous How i met your mother
                // 1
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("O?? se sont rencontr??s Ted et Barney ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Dans les toilettes du Mc Laren")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Au LaserTag")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dans un salon de massage")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dans un club de strip")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                //2
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Comment Ted veut-il appeler ses enfants ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Luke et Le??a")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Dick et Tracy")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lily et Marshall")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Batman et Robin")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //3
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Qu???est devenu l???appartement de Lily ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Un restaurant Chinois")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Un squat")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un a??roport")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un bar ?? cocktail ")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //4
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Quel est le m??tier de Barney ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("PLEASE")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Ecrivain")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Trader")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Avocat")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //5
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("De quelle nationalit?? est Robin ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Canadienne")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Francaise")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Suisse")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mexicaine")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //6
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("De quelle couleur est le cor vol?? par Ted pour Robin au d??but de la s??rie ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Bleu")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Rouge")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jaune")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ocre")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //7
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Sur qui les tableaux de Lily font-ils de l???effet ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Les animaux d'un cabinet v??t??rinaire")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Un couple de gay")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un dealer de crack")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un clown d??pressif")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //8
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("De quelle couleur sont les bottes de Ted ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Rouge")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bleu")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jaune")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ocre")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //9
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Quel est le nom du barman du McClaren ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Carl")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Jos??")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Marvin")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Rodrigo")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);


                //10
                $questionHowIMetYourMother = new Question();
                $questionHowIMetYourMother->setQuestion("Comment s???appelle le mort qui emp??che les amis de regarder en live le Super Bowl ?");
                $questionHowIMetYourMother->addQuizz($quizzHowIMetYourMother)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother);

                $proposition = new Proposition();
                $proposition->setText("Mark")->setIsValid(true)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Carl")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Doug")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mike")->setIsValid(false)->setQuestion($questionHowIMetYourMother);
                $manager->persist($proposition);

                // Testez-vous sur How i met your mother
                //1
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("De quel ??tat vient Marshall ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Minnesota")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Nevada")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Nebraska")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Alaska")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //2
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quelle c??l??brit?? la bande pense-t-elle rencontrer lors d???un r??veillon du nouvel an (S01E11) ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Moby")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Jacky Chan")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ray Parker Jr")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Britney Spears")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //3
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quelle c??l??bre sc??ne d???une c??l??bre saga a inspir?? la ???naissance??? du Barney Stinson que nous connaissons ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("La naissance de Dark Vador")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("La mort de Mufasa")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le naufrage du Titanic")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("L'attentat contre Vito Corleone")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //4
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Dans quel pays Victoria part ??tudier la patisserie ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Allemagne")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Suisse")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Canada")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Croatie")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //5
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Qu???utilise Marshall pour couvrir son ???accident??? de tondeuse le jour de son mariage ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Un chapeau")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Il se rase compl??tement")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("un masque Spiderman")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il ne vient pas")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //6
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quel est le nom de l???ex-fianc?? de Lily qui est toujours ??pris d???elle ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Scooter")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Hummer")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Beetle")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Trottinette")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //7
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Comment s???appelle le 2eme mari de la m??re de Ted ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Clint")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Daniel")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Philip")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Paul")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //8
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Comment s???appelle la premi??re fille de Marshall et Lily ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Daisy")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Claudie")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Lily Jr")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Robin")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //9
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quelles sont les 2 bibles de Barney ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Le Bro Code et le Playbook")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Oliver Twist et Tom Sawyer")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les 3 suisses et La redoute")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cujo et Shinning")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                //10
                $questionHowIMetYourMother2 = new Question();
                $questionHowIMetYourMother2->setQuestion("Quel personnage Barney imagine-t-il pour draguer ?");
                $questionHowIMetYourMother2->addQuizz($quizzHowIMetYourMother2)->addTheme($HowIMetYourMother);
                $questionHowIMetYourMother2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionHowIMetYourMother2);

                $proposition = new Proposition();
                $proposition->setText("Lorenzo Von Matterhorn ")->setIsValid(true)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Jeff Bezos")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Charlie Brown")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Barack Obama")->setIsValid(false)->setQuestion($questionHowIMetYourMother2);
                $manager->persist($proposition);


                // Personnages S??ries TV

                // 1
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Al Bundy ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Mari??s, deux enfants")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Madame est servie")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("LOST")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Heroes")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //2
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...DeeDee McCall ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Rick Hunter")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Les Dessous de Palm Beach")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cosby Show")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //3
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Angus MacGyver ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("MacGyver")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Les Experts: Las Vegas")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("N.C.I.S")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Code Quantum")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //4
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Elliot Alderson ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Mr. Robot")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("BlackList")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Stargate SG1.")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //5
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Alec Ramsey ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("L' Etalon Noir")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Tonnerre M??canique")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Rebelle")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Riptide")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //6
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Buffy Summers ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Buffy contre les vampires")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Charmed")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Sentinel")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Cam??l??on")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //7
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Sheldon Cooper ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("The Big Bang Theory")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("How i met your mother")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Au-del?? du r??el")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("24")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //8
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Jimmy McGill ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Breaking Bad")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Malcom")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The middle")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("MacGyver")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //9
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Mickael Knight ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("K2000")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Supercopter")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("L'amour du risque")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("buffy contre les vampires")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                //10
                $questionPersonnages = new Question();
                $questionPersonnages->setQuestion("Dans quelle s??rie peut-on retrouver...Arthur Pendragon ?");
                $questionPersonnages->addQuizz($quizzPersonnages)->addTheme($Personnages);
                $questionPersonnages->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages);

                $proposition = new Proposition();
                $proposition->setText("Kaamelott")->setIsValid(true)->setQuestion($questionPersonnages);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("LOST")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Sur ??coute")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Ally McBeal")->setIsValid(false)->setQuestion($questionPersonnages);
                $manager->persist($proposition);

                // Quizz perso 2
                //1
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Jonathan Dorian ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Scrubs")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Urgences")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Elite")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //2
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Sydney Bristow ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Alias")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Melrose Place")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Beverly Hills")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("N.C.I.S")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //3
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Max Guevara ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Dark Angel")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Angel")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("How i met your mother")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pretty Little Liars")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //4
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Serena van der Woodsen ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Gossip Girl")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Revenge")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Desperates housewifes")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Numbers")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //5
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Michael Scott ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("The Office US")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Prison Break")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Angel")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Les fr??res Scott")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //6
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Titus Pullo ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Rome")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Game of Thrones")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Spartacus")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Hercule")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                //7
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Jarod ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Le Cam??l??on")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Charmed")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("The Middle")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("X-Files")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //8
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Meredith Grey ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Grey's Anatomy")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Dr House")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Urgences")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("9-1-1")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //9
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...Tom Hanson ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("21 Jump Street")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("24")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Brooklyn Nine Nine")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Scrubs")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);


                //10
                $questionPersonnages2 = new Question();
                $questionPersonnages2->setQuestion("Dans quelle s??rie peut-on retrouver...James McNulty ?");
                $questionPersonnages2->addQuizz($quizzPersonnages2)->addTheme($Personnages);
                $questionPersonnages2->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionPersonnages2);

                $proposition = new Proposition();
                $proposition->setText("Sur ??coute")->setIsValid(true)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("The Shield")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dexter")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Six feet under")->setIsValid(false)->setQuestion($questionPersonnages2);
                $manager->persist($proposition);

                // Quizz Cin??ma Divers

                //1
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("Quel acteur a jou?? le premier Batman au cin??ma en 1989 ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Michael Keaton")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Julien Lepers")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Val Kilmer")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("George Clooney")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                //2
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("Quelle est la particularit?? du film Mullholland Drive de David Lynch ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Ca devait etre une s??rie")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Il est muet")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il est en 3D Imax")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Il a ??t?? tourn?? en italien")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                //3
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("A l'origine, de quel film Die Hard: Pi??ge de cristal devait il etre la suite ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Commando")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Terminator")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Top Gun")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Predator")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                //4
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("Quel est le bruitage le plus c??l??bre du cin??ma ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Le cri de Wilhelm")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Les ??perons des cow boys ")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le miaulement d'un chat la nuit")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le bruit d'un pet")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                //5
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("Combien d'acteurs ont jou?? James Bond ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("8")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("6")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("3")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("1")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                //6
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("A l'origine quelle devait ??tre la machine ?? remonter le temps de Retour vers le Futur ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Un r??frig??rateur")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Une cabine t??l??phonique")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Un cercueil")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Une trottinette ??lectrique")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                //7
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("Quel cr??ateur de comics apparaissait en cam??o dans tous les films des h??ros qu'il a cr??e ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Stan Lee")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bruce Lee")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Cora Lee")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Amay Lee")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                //8
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("Comment s'appelle la lampe mascotte de Pixar ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Luxo Jr.")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("N??on")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("E27")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Led")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                //9
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("Quel film de Pixar a ??t?? le premier ?? mettre en sc??ne des personnages humains ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Les Indestructibles")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Cars")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Toy Story")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Monde de Nemo")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                //10
                $questionCin??ma = new Question();
                $questionCin??ma->setQuestion("De quelle nationalit?? ??tait le catcheur qui a inspir?? la silhouette de Shrek ?");
                $questionCin??ma->addQuizz($quizzCin??ma->addTheme($cin??ma));
                $questionCin??ma->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma);

                $proposition = new Proposition();
                $proposition->setText("Fran??aise")->setIsValid(true)->setQuestion($questionCin??ma);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Allemande")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("G??orgienne")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Am??ricaine")->setIsValid(false)->setQuestion($questionCin??ma);
                $manager->persist($proposition);

                // Quizz Cin??ma Vari??
                //1
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Quel acteur est apparu dans les 9 films de la Saga Star Wars ? ");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Anthony Daniels - C-3PO")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Ian McDiarmid - Palpatine/L'Empereur")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Kanny Baker - R-2D2")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Peter Mayhew - Chewbacca")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //2
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Quelle autre couleur que le noir et blanc est visible dans le film La Liste de Schindler de Steven Spielberg ?
					");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Rouge")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bleu")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Vert")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jaune")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //3
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Comment s???appelle le meilleur ami de Tom Hanks dans Seul au monde ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Wilson")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Adidas")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Booba")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Harry")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //4
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Pour quel film de Disney les Daft Punk ont ils compos?? la Bande Originale ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Tron: L'H??ritage")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Bambi")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Mulan")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pocahontas")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //5
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Comment se nomme le requin des Dents de la mer ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Bruce")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Steven")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jack")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("John")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //6
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Comment s'appelle la pizz??ria de Toy Story dont la camionnette apparait dans la plupart des films Pixar ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Pizza Planet")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Pizza Chut")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dinoco's Pizza")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Pizza World")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //7
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Sur les 6 films de la franchise Transformers, combien en a r??alis?? Michael Bay ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma)); 
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("5")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                    
                $proposition = new Proposition();
                $proposition->setText("6")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("4")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("3")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //8
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Quel mot est prononc?? 226 fois dans Scarface ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("F*ck")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Coke")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Dope")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Money")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //9
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Quelle c??l??bre r??alisatrice joue le b??b?? dans la sc??ne du bapt??me dans Le Parrain ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Sofia Coppola")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Lana Wachowski")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Kathryn Bigelow")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Jane Campion")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                //10
                $questionCin??ma2 = new Question();
                $questionCin??ma2->setQuestion("Quel est le dernier film du personnage Charlot ?");
                $questionCin??ma2->addQuizz($quizzCin??ma2->addTheme($cin??ma));
                $questionCin??ma2->addTheme($movietheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionCin??ma2);

                $proposition = new Proposition();
                $proposition->setText("Les Temps Modernes")->setIsValid(true)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                                        
                $proposition = new Proposition();
                $proposition->setText("Le dictateur")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Le Kid")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);

                $proposition = new Proposition();
                $proposition->setText("Iron Man")->setIsValid(false)->setQuestion($questionCin??ma2);
                $manager->persist($proposition);
                    

                //Quizz Demo
                // 1
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quel formateur aurait pu ??tre commandant de bord pour la compagnie o'Clock Airlines ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Michael")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Alexis")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Charles")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Julien")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //2
                $questionDemo = new Question();
                $questionDemo->setQuestion("De quel animal Morgan est-il fan ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Les poneys")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Les licornes")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Les gu??pes")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Les chats")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //3
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quel est le titre du prochain livre de Charles ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Plus tard")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("symfony pour les noobs")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Guillaume Musso, le best-of")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("L'aube vue du ciel sur googlemaps")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //4
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quelle est l'autre passion d'Alexis ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("La musique")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Nous")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("La bataille navale")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Les faits divers en Dr??me occidentale")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //5
                $questionDemo = new Question();
                $questionDemo->setQuestion("Qui place des WC DANS la cuisine et pour le coup est super m??ga archi nul aux sims ? ");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Greg")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Charles")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Alexis")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Morgan")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //6
                $questionDemo = new Question();
                $questionDemo->setQuestion("Comment s'appelle le chien d'Alexis ?");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Buster")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Remorqueur")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Milou")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Achet??aim??lee")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //7
                $questionDemo = new Question();
                $questionDemo->setQuestion("Quelle est la couleur pr??f??r??e de la promo");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("fof")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("bof")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("pof")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("rohff")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


                //8
                $questionDemo = new Question();
                $questionDemo->setQuestion("Si on vous dit Ascenseur, vous pensez ?? :");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Charles")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Greg")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Julien")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Morgan")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //9
                $questionDemo = new Question();
                $questionDemo->setQuestion("Qui casse le code ?? la majorit?? de ses visites ? ");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("Alexis")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("Michael")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Greg")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("Morgane")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                //10
                $questionDemo = new Question();
                $questionDemo->setQuestion("Compl??te ces paroles : On fait le bilan, calmement ...");
                $questionDemo->addQuizz($quizzDemo)->addTheme($demo); 
                $questionDemo->addTheme($parentTheme)->setCreatedBy($tomUser); // Ne pas modifier cette ligne (Ajout de parent S??rie TV et Cr??er par Tom)
                $manager->persist($questionDemo);

                    $proposition = new Proposition();
                    $proposition->setText("...en se rem??morant chaque instant ")->setIsValid(true)->setQuestion($questionDemo);
                    $manager->persist($proposition);
                                        
                    $proposition = new Proposition();
                    $proposition->setText("... on a kiff?? tranquillement")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("... on se rappellera chaque moment")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);

                    $proposition = new Proposition();
                    $proposition->setText("... faut que j'aille chercher mes enfants")->setIsValid(false)->setQuestion($questionDemo);
                    $manager->persist($proposition);


				/**
				 * quizzFriends
				 * quizzFriends2
				 * quizzKaamelott
				 * quizzKaamelott2
				 * quizzScrubs
				 * quizzScrubs2
				 * quizzAnn??es8090
				 * quizzNostalgie8090
				 * quizzHowIMetYourMother
				 * quizzHowIMetYourMother2
				 * quizzPersonnages
				 * quizzPersonnages2
				 * quizzCin??ma
				 * quizzCin??ma2
				 * quizzDemo
				 */	
				
				$allQuizz = [
					$quizzFriends, $quizzFriends2,
					$quizzKaamelott, $quizzKaamelott2,
					$quizzScrubs, $quizzScrubs2,
					$quizzAnn??es8090, $quizzNostalgie8090,
					$quizzHowIMetYourMother, $quizzHowIMetYourMother2,
					$quizzPersonnages, $quizzPersonnages2,
					$quizzCin??ma, $quizzCin??ma2,
					$quizzDemo
				];
				
				$histoOquizz = [
					$quizzAnn??es8090, $quizzNostalgie8090,
					$quizzHowIMetYourMother, $quizzHowIMetYourMother2,
					$quizzPersonnages, $quizzPersonnages2
				];

				$robinQuizz = [
					$quizzFriends, $quizzFriends2,
					$quizzKaamelott, $quizzKaamelott2,
					$quizzScrubs, $quizzScrubs2,
					$quizzCin??ma, $quizzCin??ma2,
					$quizzDemo				
				];

				$corentinQuizz = [
					$quizzScrubs, $quizzScrubs2,
					$quizzAnn??es8090, $quizzNostalgie8090,
					$quizzHowIMetYourMother, $quizzHowIMetYourMother2,
					$quizzPersonnages, $quizzPersonnages2,
					$quizzCin??ma, $quizzCin??ma2,			
				];

				$fanouQuizz = [
					$quizzFriends, $quizzFriends2,
					$quizzKaamelott, $quizzKaamelott2,
					$quizzScrubs, $quizzScrubs2,
					$quizzAnn??es8090, $quizzNostalgie8090,
					$quizzCin??ma, $quizzCin??ma2,
					$quizzDemo
				];				

				foreach($histoOquizz as $quizz) {
					$fakeGame = new Historic();
					$fakeGame->setQuizz($quizz);
					$fakeGame->setUser($oquizzUser);
					$fakeGame->setScore(rand(0, 10));
					$fakeGame->setOutOf(10);
					$manager->persist($fakeGame);
				}

				for ($i = 0; $i < 10; $i++) {
					foreach($allQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($tomUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				for ($i = 0; $i < 8; $i++) {
					foreach($robinQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($robinUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				for ($i = 0; $i < 7; $i++) {
					foreach($corentinQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($corentinUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				for ($i = 0; $i < 6; $i++) {
					foreach($fanouQuizz as $quizz) {
						$fakeGame = new Historic();
						$fakeGame->setQuizz($quizz);
						$fakeGame->setUser($fanouUser);
						$fakeGame->setScore(rand(0, 10));
						$fakeGame->setOutOf(10);
						$manager->persist($fakeGame);
					}
				}

				$manager->flush();
	}
}