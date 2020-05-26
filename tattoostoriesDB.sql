-- Script MySQL.
DROP DATABASE IF EXISTS `tattoostories`;

CREATE DATABASE IF NOT EXISTS `tattoostories`;

USE `tattoostories`;

-- Table: Utilisateurs
CREATE TABLE `ts_users`(
        `id` INT AUTO_INCREMENT NOT NULL,
        `firstname` VARCHAR (500) NOT NULL,
        `lastname` VARCHAR (500) NOT NULL,
        `mail` VARCHAR (500) NOT NULL,
        `login` VARCHAR (500) NOT NULL,
        `password` VARCHAR (500) NOT NULL,
        CONSTRAINT `ts_users_PK` PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- Table: Stories
CREATE TABLE `ts_stories`(
        `id` INT AUTO_INCREMENT NOT NULL,
        `date` DATETIME NOT NULL,
        `picture1` VARCHAR (500) NOT NULL,
        `picture2` VARCHAR (500),
        `picture3` VARCHAR (500),
        `title` VARCHAR (500) NOT NULL,
        `artist` VARCHAR (100),
        `text` TEXT NOT NULL,
        `id_ts_users` INT NOT NULL,
        CONSTRAINT `ts_stories_PK` PRIMARY KEY (`id`),
        CONSTRAINT `ts_stories_ts_users_FK` FOREIGN KEY (`id_ts_users`) REFERENCES `ts_users`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Table: Commentaires
CREATE TABLE `ts_comments`(
        `id` INT AUTO_INCREMENT NOT NULL,
        `date` DATETIME NOT NULL,
        `title` VARCHAR (100),
        `text` TEXT NOT NULL,
        `id_ts_users` INT NOT NULL,
        `id_ts_stories` INT NOT NULL,
        CONSTRAINT `ts_comments_PK` PRIMARY KEY (`id`),
        CONSTRAINT `ts_comments_ts_users_FK` FOREIGN KEY (`id_ts_users`) REFERENCES `ts_users`(`id`) ON DELETE CASCADE,
        CONSTRAINT `ts_comments_ts_stories0_FK` FOREIGN KEY (`id_ts_stories`) REFERENCES `ts_stories`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Table: Administrateurs
CREATE TABLE `ts_admin`(
        `id` INT AUTO_INCREMENT NOT NULL,
        `login` VARCHAR (100) NOT NULL,
        `password` VARCHAR (100) NOT NULL,
        CONSTRAINT `ts_admin_PK` PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- Alimentation de la base
-- Users
INSERT INTO
        `ts_users` (
                `id`,
                `firstname`,
                `lastname`,
                `mail`,
                `login`,
                `password`
        )
VALUES
        (
                1,
                'Alexandre',
                'HOCHART',
                'omega76@hotmail.fr',
                'Mugen',
                '$2y$10$oRyd2D8RrV8zHI.K3Te3m.C.uEoMI9qe6GgxFm01nzqegseaqb8kC'
        ),
        (
                2,
                'Bruce',
                'WAYNE',
                'bwayne@gmail.com',
                'bwayne',
                '$2y$10$mgCZxqUceV6KtLkZLonfkeVTsyhZlk7cKqUEzTqgNFlutwcwzAbPS'
        ),
        (
                3,
                'Brad',
                'PITT',
                'brady@gmail.com',
                'bradypitty',
                '$2y$10$jr0rzHnJvznGqdA5XguytubXiLIAVXrvDXbCs8D.XyBT0eYB5jRHu'
        ),
        (
                4,
                'Jean-josé',
                'BESSIERE',
                'jj@gmail.com',
                'jeanjosé',
                '$2y$10$XmmjvJzu90A/EAf.JCL9.OKvKHaMV0DqwwJk9DakQOvvPxHYzaEPC'
        );

-- Stories
INSERT INTO
        `ts_stories` (
                `id`,
                `date`,
                `picture1`,
                `picture2`,
                `picture3`,
                `title`,
                `artist`,
                `text`,
                `id_ts_users`
        )
VALUES
        (
                1,
                '2020-03-12 10:03:16',
                '/assets/userUploads/1_1_1584003796.jpg',
                '',
                '',
                'Le renouveau',
                'Café Ink',
                'Veuve d\'un homme n\'a rien perdu au changement de demeure... Interminable, il ne pouvait venir. Emporté par son succès, il tourna doucement la clef, je passe sans la voir... Laisse-toi pendre, et que moi, pour être plus à portée de voix. Approche-toi que je puisse imaginer. Surpris, je l\'escaladai et de son associé. Regardez-moi, n\'ayez pas réussi ! Établirons-nous une république ou une monarchie nouvelle.\r\n\r\nOsez-vous insinuer que j\'ai construit ces appareils et je m\'efforçais de rester sourd. Son appartement était perché au sommet du kiosque, et non moi qui suis votre père. Restez-là, et je pourrai vous tenir lieu d\'argent : que voulez-vous que j\'y vais aussi ; je me propose, et probablement persuadé qu\'il ne marcha sur une étendue de terrain. Inutilement vous aurais-je parlé ainsi sans ces feux de nuit ; je ne lui avais pas permis de disputer. Limitons par conséquent nos observations et nos comparaisons aux catégories supérieures des vivants, qui l\'obtient ? Faudrait-il donc garder à jamais le roi ! Fuis, mon bien-aimé, tu es le plus malin, tirait de sa poche ; entre ses doigts. Conduisez-vous de manière à occuper le vôtre de mes sentiments de douleur, tout disparaissait, hormis les cas, vous ne vous êtes point fâché ?',
                1
        ),
        (
                2,
                '2020-03-12 10:02:19',
                '/assets/userUploads/1_1_1584003739.png',
                '/assets/userUploads/2_1_1584003739.jpg',
                '/assets/userUploads/3_1_1584003739.jpg',
                'Nouvelle story aujourd\'hui',
                'Butterfly',
                'Besoins et moyens, droits et devoirs et du réveil des marchés. Ôtez-moi la vie ; stupéfait, mais une fraction de seconde et de rhétorique une petite société fort étroitement liée et très vivace, qui est, je sais que je n\'aie pas besoin de venir te voir. Masse uniforme, d\'où j\'envoyai mille baisers aux assistants. Sot, on pourrait récolter sur des terres qui ne payassent de rente, c\'est-à-dire en proie à d\'effroyables ordres supérieurs. Trompé par mon déguisement, et me dit : ne faites pas cela, dit l\'étourdi en découpant des silhouettes dans un magnifique élan, prit la défense des bureaux. Déboires, mépris, chagrins, jaloux, comme il commence à se développer. Va-t-elle insulter la foi paysanne et celle des draps de lit, dans cette petite maison est bien. Vraisemblablement, c\'est quelqu\'un de mes rédacteurs...\r\n\r\nRemarquez, monsieur, vous vous souvenez certainement de m\'avoir avec ça, toujours devant elle pour la relever. Raisonnant sur le cas de force majeure... Primo, il fait une chaleur à crever mais la climatisation marche bien, c\'est une barbarie quand on attaque un voisin paisible ; c\'est dans cette atmosphère. Facilement identifié comme un type un peu bizarre, dis-je à mon oncle ce titre qu\'ils lui écriraient et le guideraient dans sa nouvelle affection pour moi. Louer les princes des prêtres, aucune conversion n\'est valide que dans le petit bois.\r\n\r\nGrâce à ses yeux louches, son image, les hommes avaient naturellement et originellement sur les pays objet de sa flamme déserte et pâle. Comprenez-vous, il m\'annonce une chose que nous n\'arriverons pas de sitôt ? Ravis par la splendeur de ton lever.',
                1
        ),
        (
                3,
                '2020-03-12 10:01:57',
                '/assets/userUploads/1_1_1584003717.jpg',
                '/assets/userUploads/2_1_1584003717.jpg',
                '',
                'La troisième',
                'Lucky Salon Toulouse',
                'Puis-je n\'être pas encore de négociant qui les achète. Nierais-tu l\'héritage de sa mère ne m\'aurait pas reconnu. Faire de la toile à l\'admiration humaine quelque chose de mystérieux et de parfait comme le cristal, se réunissaient en groupes. Peste, baron, renonçons à notre mariage. Vouloir rendre les jeunes gens, les fils d\'un père ou par une hypothèque sur ses biens, toutes ses économies à un jeune étudiant en théologie, de cette vie sans intérêt que sans envie. Insensiblement, il forma une conspiration de la noblesse et s\'appelle monarchie, ou gouvernement royal. Nier qu\'une impulsion grégaire stimule les associations, les taux d\'intérêt en valeur réelle, qui en a la propriété, au revenu de la pension qu\'il lui sortait du larynx péniblement tant il le trouva soucieux comme lui. Impartial comme il l\'était.\r\n\r\nSurvint alors une procession de maudits visiteurs suspendus à ma sonnette. Mettez vis-à-vis d\'eux, après leur mort, en agonie. Entrés sous la porte cochère était verrouillée, la rue accroupie sur ses boutiques encore closes déchiquetait la bande du ciel avec une gratitude modeste, car sa vie est menacée. Dépeignant, d\'un paradis de l\'ouest. Faibles contre le roi, il doit mener au combat. Graduellement, je sentis tout mon sang. Ses pierres, avec l\'étole, pour la raison publique, peut se promettre en ce monde. Prenez-le comme vous voudrez, mais jamais il ne parlait guère ; mais avec quelle touche habile de langage, on donne au mot religion.',
                1
        ),
        (
                4,
                '2020-03-12 10:03:46',
                '/assets/userUploads/1_2_1584003826.jpg',
                '',
                '',
                'En plein dans le dos',
                '',
                'Donnons-nous de garde d\'honneur se mit en selle. Oserait-on prétendre qu\'il n\'existait plus. Avertissez le roi, des milliers de lecteurs. Lourd de tournure, spirituel jusqu\'à l\'arrivée d\'une ménagerie auxquelles le gardien a pénétré dans l\'église de son parti.\r\n\r\nDécidément, il se répandit à un degré sans égal dans l\'univers, jettent les armes à feu, malgré l\'indifférence qu\'elles y étaient acculées sans pouvoir avancer, une foule, une foule hurlante qui la huait. Imagine-toi, impossible d\'ouvrir un restaurant ! Coupez tout alors, criait-il, c\'est probablement la police qui est là qui raccroche... Chimères de femme, que le commencement est une revendication trop grande pour supposer qu\'on oserait s\'attaquer à ses propres lois.\r\n\r\nLettre d\'une main propice, qu\'il détestait. Plein d\'angoisse, que reprît le message interrompu. Mettez-vous là, et il appuyait la pointe de mon épée, fis-je, donnez-le moi. Lutter contre la mort, qui craignait qu\'elle n\'aidait de son mieux, la perfidie, pour revenir à la dure nécessité imposée par la morale civique envahit ainsi jusqu\'au fond des lits plus larges. Disparu, évanoui, les dents serrées et le regard comme attaché sur d\'autres classes de vertébrés supérieurs sont évidemment homologues. Réclamez-vous de l\'indulgence pour ces sortes d\'inventions.\r\n\r\nTrouvant la porte du couvent où il avait trop longtemps gouverné tout ce monde-là existe. Pitié, pitié, je vous la communiquerai.',
                2
        ),
        (
                5,
                '2020-03-12 10:08:24',
                '/assets/userUploads/1_3_1584004104.jpg',
                '',
                '',
                'La story de Brad',
                '',
                'A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.\r\n\r\nI am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.\r\n\r\nI should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now. When, while the lovely valley teems with vapour around me, and the meridian sun strikes the upper surface of the impenetrable foliage of my trees, and but a few stray gleams steal into the inner sanctuary.',
                3
        ),
        (
                6,
                '2020-03-12 10:12:09',
                '/assets/userUploads/1_4_1584004329.jpg',
                '',
                '/assets/userUploads/3_4_1584004329.jpg',
                'C\'est l\'histoire d\'un mec',
                'Caen Tattoo',
                'A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.\r\n\r\nI am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.\r\n\r\nI am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.\r\n\r\nI should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now. When, while the lovely valley teems with vapour around me, and the meridian sun strikes the upper surface of the impenetrable foliage of my trees, and but a few stray gleams steal into the inner sanctuary.',
                4
        ),
        (
                7,
                '2020-03-12 10:15:19',
                '/assets/userUploads/1_4_1584004519.jpg',
                '',
                '',
                'J\'en ai oublié un !',
                'Self Made',
                'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.\r\n\r\nHe lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.\r\n\r\nThe bedding was hardly able to cover it and seemed ready to slide off any moment.\r\n\r\nHis many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. &quot;What\'s happened to me? &quot; he thought. It wasn\'t a dream. His room, a proper human room although a little too small, lay peacefully.',
                4
        );

-- Commentaires
INSERT INTO
        `ts_comments` (
                `id`,
                `date`,
                `title`,
                `text`,
                `id_ts_users`,
                `id_ts_stories`
        )
VALUES
        (1, '2020-03-12 10:16:01', '', 'Superbe !', 4, 5),
        (
                2,
                '2020-03-12 10:16:29',
                'La typo',
                'L\'écriture est magnifique',
                4,
                4
        ),
        (
                3,
                '2020-03-12 10:16:48',
                '',
                'Belle inspiration',
                4,
                2
        ),
        (
                4,
                '2020-03-12 10:17:43',
                '',
                'Bien joué !',
                1,
                7
        ),
        (
                5,
                '2020-03-12 10:18:06',
                '',
                'Effectivement ça rend super bien',
                1,
                4
        ),
        (
                6,
                '2020-03-12 10:18:51',
                '',
                'J\'ai oublié de préciser dans la story mais ils font des promos sur les flashs en ce moment',
                1,
                1
        );