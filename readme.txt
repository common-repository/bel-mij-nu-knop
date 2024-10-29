=== Plugin Name ===
Contributors: alphabase, maartenbrakkee
Tags: call, callmenow, pbx, belcentrale, voipnow, 4psa, managed, hosted, phone, phonecall, belmijnu, bellen, telefoneren, telefonie
Requires at least: 3.3.2
Tested up to: 3.8.1
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://www.belcentrale.nl/voip/index.jsp?p=contact

Laat uw Wordpress-bezoekers rechtstreeks met u bellen via de Bel-Mij-Nu-knop van Belcentrale op uw website.

== Description ==

De Bel-Mij-Nu-knop voor Wordpress stelt u, als Belcentrale klant, in staat om in no-time uw telefonische bereikbaarheid te verbeteren. Bezoekers van uw website kunnen voortaan direct met uw bedrijf in contact komen, door hun telefoonnummer op uw website in te voeren. De Call-API koppeling met onze PBX-server maakt het mogelijk om direct een gesprek op te starten.

== Installation ==

1. Upload de map `callmenow` naar de `/wp-content/plugins/` map
2. Activeer de plugin via het 'Plugins' menu in het Wordpress Dashboard
3. Pas uw instellingen aan door in het Wordpress Dashboard naar 'Instellingen' > 'Bel-Mij-Nu-knop' te gaan
4. Schakel de Bel-Mij-Nu-knop in om de widget te activeren
5. Voer uw telefoonnummer in, welke gebeld moet worden
6. Selecteer welke telefoonnummers u wilt toestaan
7. Voer uw Call-API gegevens in, welke u kunt verkrijgen via de Belcentrale support-afdeling
8. Voer uw openingstijden in of laat deze leeg om altijd bereikbaar te zijn
9. Ga naar de Wordpress Widgets via 'Weergave' > 'Widgets'
10. Sleep de 'Bel-Mij-Nu' widget naar een beschikbare plaats van uw thema
11. Verander eventueel de weergegeven teksten
12. Sla uw instellingen op

Veel plezier met de Bel-Mij-Nu-knop van Belcentrale voor Wordpress!

== Frequently Asked Questions ==

= Mijn openingstijden lijken niet te werken = 

Let er op dat de tijdzone van uw Wordpress-installatie uw correcte lokale tijd weergeeft. Hiervoor gaat u in het Wordpress Dashboard naar 'Instellingen' en 'Algemeen'. Daar moet de lokale tijd overeen komen.

= Hoe wordt het gesprek in gang gezet? =

1. De bezoeker voert zijn/haar telefoonnummer in de widget in
2. Het telefoonnummer wordt gevalideerd aan de hand van uw 'Telefoonnummers toestaan' opties
3. De configuratie van uw plugin wordt gecontroleerd
4. De door u ingevoerde openingstijden worden gecontroleerd
5. De verbinding met onze PBX-server en uw Call-API rechten worden gecontroleerd
6. De bezoeker wordt eerst gebeld op het door hem/haar ingevulde telefoonnummer
7. Zodra de bezoeker de telefoon opneemt, wordt uw telefoonnummer gebeld

= Bent u reeds klant van Belcentrale? =

Bij onze support-afdeling kunt u de Call-API gegevens van uw PBX-centrale opvragen. Met deze gegevens kunt u de Wordpress Widget uw PBX-centrale laten aansturen. U kunt onze support-afdeling bereiken via het e-mailadres support@belcentrale.nl of via het freeform contactformulier in het online control panel op www.belcentrale.nl.

= Bent u geen klant van Belcentrale? =

Met een gratis testaccount van Belcentrale kunt u vrijblijvend op uw eigen tempo kennis maken met de kwaliteit, betrouwbaarheid en flexibiliteit van onze diensten. U kunt een gratis testaccount aanvragen op onze website: [www.belcentrale.nl](http://www.belcentrale.nl/voip/index.jsp?p=probeer "Gratis testaccount aanvragen").

== Screenshots ==

1. Wordpress Dashboard: Plugin instellingen bewerken
2. Wordpress Dashboard: Widget teksten aanpassen
3. Wordpress website: Uiterlijk Bel-Mij-Nu-knop
4. Wordpress website: Foutmelding na onacceptabel telefoonnummer

== Changelog ==

= 2.0 =
* VoipNow 3 servers worden nu ondersteund
* PBX servers 17 en 18 zijn toegevoegd
* CSS weergave problemen opgelost

= 1.4 =
CSS-bestand aangepast zodat het niet afhankelijk is van de aanwezigheid van "aside" in de template

= 1.1 =
Readme bestand aangepast om een voorziene veelgestelde vraag te beantwoorden

= 1.0 =
* Managed-PBX koppeling naar uw account bij Belcentrale
* Widget teksten aanpassen om uw doelgroep het beste aan te kunnen spreken
* Telefoonnummer accepteren op basis van validatieregels
* Openingstijden toevoegen om buiten kantooruren niet gebeld te worden

== Upgrade notice ==
Alle bestanden kunnen overschreven worden, de data wordt in de database opgeslagen.