# FILM Projektterv 2019

## 1. Összefoglaló

A Film című projektet kaptuk, ami arról szól, hogy online filmkatalógust csináljunk, ami képes arra, hogy filmeket töltsünk fel rá, majd ezeket a regisztrált felhasználók tudják
véleményezni emelett pedig tudjanak rájuk szavazni is. Fontos szempont, hogy alkalmas kell legyen az oldal arra, hogy különböző szempontok alapján a felhasználók lekérdezhessék a filmeket.

## 2. Verziók

| Verzió |  Szerző  |   Dátum    |  Státusz   |   Megjegyzés   |
| :----: | :------: | :--------: | :--------: | :------------: |
|  0.1   | Mindenki | 2019-09-10 | Elfogadott | Legelső verzió |

Státusz osztályozás:
Film: Online filmkatalógus (filmek feltöltése, regisztrált felhasználók véleményezhetik, szavazhatnak, különböző szempont szerint lekérdezhetik, stb. ~ imdb)

- Tervezet: befejezetlen dokumentum
- Előterjesztés: a projekt menedzser bírálatával
- Elfogadott: a megrendelő által elfogadva

## 3. A projekt bemutatása

Ez a projektterv a FILM projektet mutatja be, mely 2019.09.02-től 2019.12.06-ig tart. A projekt célja a csapatmunka megismerése illetve egy oldal elkészitésenek elsajátitása

### 3.1. Rendszerspecifikáció

A Film címü projekt arról szól, hogy online filmkatalógust csináljunk ami képes arra, hogy filmeket töltsünk fel rá majd ezeket a regisztrált felhasználók tudják
véleményezni emellett pedig tudjanak rájuk szavazni is. Fontos szempont hogy, alkalmas kell legyen az oldal arra, hogy különböző szempontok alapján a felhasználók lekérdezhessék a filmeket.
Az előbb felsorolt dolgokat fogja tudni a projekt és ezeket a paramétereket várja el a felhasználo és a megrendelő is.

### 3.2. Funkcionális követelmények

-online filmkatalógus  
-filmek feltöltése
-regisztrált felhasználók véleményezhessék a filmeket
-regisztrált felhasználók tudjanak szavazni  
-szempontok alapján a felhasználók lekérdezhessék a filmeket

• Felhasználó regisztráció, belépés
o Felhasználói adatok (felhasználónév (email), jelszó) mentése az adatbázisba regisztráció során
o Bejelentkezési adatok ellenőrzése bejelentkezés során

• Felhasználói adatmódosítás:
o email, telefonszám, jelszó

### 3.3. Nem funkcionális követelmények

A futtatási környezet böngésző.
Filmek lekérdezhetősége működjön, illetve hozzászólások.
Modern 'minimalistic' design, intuitiív kezelhetőség, felhasználóbarát.

A rendszernek minden korszerű böngészőben megfelelően kell működnie.
Fontos, hogy a felhasználó adatait biztonságosan kezelje az oldal.
Lényeges elvárás, a keresések, szűrések futási idejének optimális megvalósítása.
Az oldalnak áttekinthetőnek, könnyen értelmezhetőnek kell lennie.
Az alkategóriák jól elkülönüljenek, ne okozzon problémát az átlag felhasználó számára egy bizonyos termék megkeresése.

## 4. Költség- és erőforrás-szükségletek

Az erőforrásigényünk kb. 5*10=50 személynap.
A rendelkezésünkre áll 5*60 pont.

## 5. Szervezeti felépítés és felelősségmegosztás

A projekt megrendelője Dr. Kertész Attila. A Film projektet a projektcsapat fogja végrehajtani, akik: Schneider Sigfrid, Mackovic Daniel, Tóth Bagi Bence, Szekeres Laura, Róka Tamás.

### 5.1 Projektcsapat

A projekt a következő emberekből áll:

|                                            |        Név         |   E-mail cím (stud-os)   |
| :----------------------------------------: | :----------------: | :----------------------: |
|                 Megrendelő                 | Dr. Kertész Attila |  keratt@inf.u-szeged.hu  |
| Projekt menedzser, Dokumentációért felelős | Schneider Sigfrid  | h674415@stud.u-szeged.hu |
| Adatbázisért és adatkapcsolatokért felelős |  Mackovic Daniel   | h879355@stud.u-szeged.hu |
|     Felhasználói felületekért felelős      |   Szekeres Laura   | h880629@stud.u-szeged.hu |
|  A rendszer működési logikájáért felelős   |     Róka Tamás     | h880258@stud.u-szeged.hu |
|           Prezentációért felelős           |  Tóth Bagi Bence   | h880969@stud.u-szeged.hu |

## 6. A munka feltételei

### 6.1. Munkakörnyezet

A projekt a következő munkaállomásokat fogja használni a munka során:
Acer aspire 3 A315-41-R6AR
Asztali számítógép (Win10/Ubuntu)
ASUS X552C
ASUS N580VD
Acer Aspire 5 A515-51G-51JP

• Szoftverkörnyezet: Windows operációs rendszert, Eclipse, IntelliJ IDE-ket használunk. Adatbázishoz MySQL Workbench. A verziókezelés giten történik.

### 6.2. Rizikómenedzsment

1. Meghibásodott munkaállomás esetén, a hibás eszköz mihamarabbi pótlása a cél, végső esetben használatba lehet venni az Irinyi kabinet számítógépeit. Ennek az esélye közepes, és jelentősen lassítja a munkamenetet.
2. Betegség: Kisebb betegség során lényeges kár nem történik, a munkafolyamat minimálisan lassul. Kisebb betegségre az esély nagyon magas. Ilyenkor a kiesett projekttag munkáját a többiek segítik elő.
   Komolyabb betegség esetén a projekt átszervezése valósul meg. Ha lehetséges, akkor csak a beteg projekttag feladatkörét osztjuk szét, ha ez nem sikerül megfelelően akkor a feladatok teljes reallokációja történik.
3. Szoftver probléma: Akárhány embernél jelentkezik, pár napon belül orvosolható, jelentős kár nem származik belőle, minimálisan lassítja a munkafolyamatot.
4. Utazás: Erre az esély kevés, viszont, ha bekövetkezik, akkor ha távmunka megoldható, akkor csak a kommunikáció nehezül meg, de ez nem számottevő. Ha a távmunka nem oldható meg, akkor a kiesett tag feladatkörének megosztása, végső esetben az összes feladatkör reallokálása valósul meg.
5. Emberi trehányság: Az időpontok nem betartása és a kommunikáció hiánya a csapat felé a munka lassítását eredményezi, így a munkafolyamatok eltolódnak.

## 7. Jelentések

### 7.1. Munka menedzsment

A munkát Schneider Sigfrid menedzseli. Feladatai: munka beosztása, pontozás, dokumentáció készités, vitás kérdések elrendezése, csapat figyelése, kommunikálása, hogy minden a kiszabott idöben legyen kész, illetve, hogy ne legyenek csúszások.

### 7.2. Csoportgyűlések

Első megbeszélés: megbeszéltük ki készíti el a gitlab csoportot és csináltunk egy értekező csoportot facebookon. Megjelenő tagok: mindenki ott volt

Második megbeszélés: létrehoztuk a gitlab csoportot és feltöltöttük a dokumentációt. Megjelenő tagok:-Szekeres Laura
-Róka Tamás
-Schneider Sigfrid

Harmadik megbeszélés: együtes erővel megbeszélzük a gitlab fentmaradó részeit illetve eldöntöttük ki mit fog csinálni. Megjelenö tagok mindenki kivéve:
Tóth Bagi Bence

Negyedik megbeszélés: a projektterv további kitöltése/részletesebb feladat beosztás. Megjelenő tagok mindenki kivéve: Mackovic Daniel

### 7.3. Minőségbiztosítás

Az elkészült terveket a terveken nem dolgozó csapattársak közül átnézik, hogy megfelel-e a specifikációnak és az egyes diagramtípusok összhangban vannak-e egymással. A meglévő rendszerünk helyes működését a prototípusok bemutatása előtt a tesztelési dokumentumban leírtak végrehajtása alapján ellenőrizzük és összevetjük a specifikációval, hogy az elvárt eredményt kapjuk-e. További tesztelési lehetőségek: unit tesztek írása az egyes modulokhoz vagy a kód közös átnézése (code review) egy, a vizsgált modul programozásában nem résztvevő csapattaggal. Szoftverünk minőségét a végső leadás előtt javítani kell a rendszerünkre lefuttatott kódelemzés során kapott metrikaértékek és szabálysértések figyelembevételével.
Az alábbi lehetőségek vannak a szoftver megfelelő minőségének biztosítására:

- Specifikáció és tervek átnézése (kötelező)
- Teszttervek végrehajtása (kötelező)
- Unit tesztek írása (választható)
- Kód átnézése (választható)

### 7.4. Átadás, eredmények elfogadása

A projekt eredményeit Dr. Kertész Attila fogja elfogadni. A projektterven változásokat csak Dr. Kertész Attila írásos kérés esetén Dr. Kertész Attila engedélyével lehet tenni. A projekt eredményesnek bizonyul, ha specifikáció helyes és határidőn belül készül el. Az esetleges késések pontlevonást eredményeznek.
Az elfogadás feltételeire és beadás formájára vonatkozó részletes leírás Kertész Attila fő gyakorlatvezető honlapján olvasható.

### 7.5. Státuszjelentés

Minden leadásnál a projektmenedzser jelentést tesz a projekt haladásáról, és ha szükséges változásokat indítványoz a projektterven. Ezen kívül a megrendelő felszólítására a menedzser 3 munkanapon belül köteles leadni a jelentést. A gyakorlatvezetővel folytatott csapatmegbeszéléseken a megadott sablon alapján emlékeztetőt készít a csapat, amit a következő megbeszélésen áttekintenek és felmérik az eredményeket és teendőket. Továbbá gazdálkodnak az erőforrásokkal és szükség esetén a megrendelővel egyeztetnek a projektterv módosításáról.

## 8. A munka tartalma

### 8.1. Tervezett szoftverfolyamat modell és architektúra

Agilis tervezési modellt követve állítja össze a csapat a specifikációnak megfelelő projekteket.
Választásunk azért esett erre a szoftverfejlesztési mintára, mert elősegíti az alkalmazkodó tervezést, az evolúciós fejlesztést, a folytonos továbbfejlesztést és megkönnyíti a változásokra adható gyors és rugalmas válaszadást.
A rendszernek 3 rétegje lesz:
• Backend: PHP
• Frontend: HTML+CSS, JavaScript
• Adatbázis: MySQL
Ezek mellett a szoftverfejlesztésben gyakran használt szerkezeti mintát, az MVC-t követjük.
A kommunikáció a rétegek között http protokollon keresztül fog menni.

### 8.2. Átadandók és határidők

A főbb átadandók és határidők a projekt időtartama alatt a következők:

| Szállítandó |                Neve                 | Határideje |
| :---------: | :---------------------------------: | :--------: |
|     D1      |       Projektterv és útmutató       | 2019-10-03 |
|    P1+D2    | UML és adatbázis tervek és bemutató | 2019-10-11 |
|    P1+D3    |      Prototípus I. és bemutató      | 2019-11-05 |
|    P2+D4    |     Prototípus Ii. és bemutató      | 2019-12-02 |

## 9. Feladatlista

A Film projekt 2019. szeptember 05-én indult. A következőkben a tervezett feladatok részletes összefoglalása található:

### 9.1. Projektterv (1. mérföldkő)

Ennek a feladatnak a célja a csapat létrehozása, ezt követően a feladat kiválasztása, majd megterveztük a projektterv dokumentumot. Ezután kiosztottuk a munkafolyamatokat a csapat tagjai között.
Felelősök: Mindenki
Tartam: 3 hét
Erőforrásigény: 2 személynap

### 9.2. UML és adatbázis tervek (2. mérföldkő)

A cél, hogy a projektünk alapját alkotó elemeket részletesen megtervezzük, hogy rálátásunk legyen arra, hogy melyik komponens mivel, hogyan kommunikáljon. Az egyes diagrammok és tervek segítségével az implementáció sokkal egyszerűbb lesz, így nem a kódolás során kell kitalálni, hogy mit és mi módon kéne megvalósítani. Az alapos tervek alapján így egy sokkal biztosabb rendszert tudunk felépíteni.
Részfeladatai a következők: Adatbázis és diagramok létrehozása
Felelősök: Mackovic Daniel
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.1. Use Case diagram

Felelősök: Schneider Sigfrid
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.2. Class diagram

Felelősök: Róka Tamás
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.3. Sequence diagram

Felelősök:Róka Tamás
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.4. Egyed-kapcsolat diagram adatbázishoz

Felelősök: Mackovic Daniel
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.5. Package diagram

Felelősök: Tóth Bagi Bence
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.6. Képernyőtervek

Felelősök: Szekeres Laura
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.7. Tesztesetek, teszttervek

Felelősök: Schneider Sigfrid
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.2.8. Bemutató elkészítése és bemutatása

Felelősök:Tóth Bagi Bence, Szekeres Laura
Tartam: 1 hét
Erőforrásigény: 5 személynap

### 9.3. Prototípus I. (3. mérföldkő)

A Prototípus I. mérföldkő célja, egy már, a fő funkciókat tartalmazó, de még nem végleges projekt létrehozása.
Amit a Prototípus I.-nek tartalmaznia kell:
 Regisztráció, belépés
 film keresése, szűrése
 Admin felület, amin belül: a film feltöltése, törlése és a hozzászolás kezelése

Részfeladatai a következők:

#### 9.3.1. Prototípus

Felelősök:Mindenki
Tartam: 2 hét
Erőforrásigény: 10 személynap

#### 9.3.2. Tesztelési dokumentum

Felelősök: Róka Tamás  
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.3.3. Bemutató elkészítése és bemutatása

Felelősök: Róka Tamás
Tartam: 1 hét
Erőforrásigény: 1 személynap

### 9.4. Prototípus II. (4. mérföldkő)

A cél a végleges projekt elkészítése, a GUI teljes megvalósítása, és a plusz funkciók implementálása. Fontos, hogy minden hibát kijavítsunk, ami esetleg eddig a Prototípus-I.-ben volt.
Amit a Prototípus II.-nek tartalmaznia kell:
 film keresés, szűrés részletesebben
 Admin felület:
• kommentek kezelése
 Felhasználó felület:
• adatok kezelése (email, jelszó, telefonszám…)

Részfeladatai a következők:

#### 9.4.1. Dokumentációk, tervek új funkciókkal

Felelősök:Schneider Sigfrid
Tartam: 1 hét
Erőforrásigény: 5 személynap

#### 9.4.2. Javított minőségű prototípus új funkciókkal

Felelősök: Mackovic Daniel
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.4.3. Tesztelési dokumentum új funkciókhoz

Felelősök: Tóth Bagi Bence
Tartam: 1 hét
Erőforrásigény: 1 személynap

#### 9.4.4. Bemutató elkészítése és bemutatása

Felelősök: Schneider Sigfrid
Tartam: 1 hét
Erőforrásigény: 4 személynap

## 10. Részletes időbeosztás

1. Projektterv: 2019. 09. 17 – 2019. 09. 28.

2. UML diagrammok, adatbázis tervek: 2019. 10. 01. – 2019. 10. 08.

o 2.1 Use-case diagram: 2019. 10. 01. – 2019. 10. 02.
o 2.2 Sequence diagram: 2019. 10. 03 – 2019. 10. 04.
o 2.3 Képernyő tervek: 2019. 10. 03. – 2019. 10. 04.
o 2.4 Class diagram: 2019. 10. 03. – 2019. 10. 04.
o 2.5 Package diagram: 2019. 10. 05. – 2019. 10. 05.
o 2.6 Egyed kapcsolat diagram: 2019. 10. 05. – 2019. 10. 05.
o 2.7 Tesztesetek, teszttervek: 2019. 10. 03. – 2019. 10. 03.
o 2.8 Bemutató elkészítése: 2019. 10. 08. – 2019. 10. 08.

3 Prototípus I. : 2019. 10. 09. – 2019. 10. 18.

o 3.1 Prototípus: 2019. 10. 09. – 2019. 10. 18
o 3.2 Tesztelési dokumentum: 2019. 10. 15. – 2019. 10. 18.
o 3.3 Bemutató: 2019. 10. 16. – 2019. 10. 17.

4. Prototípus II.: 2019. 10. 19. – 2019. 11. 09.

o 4.1 Javított prototípus, új funkciókkal: 2019. 10. 19. – 2019. 11. 09.
o 4.2 Dokumentáció a prototípus II-ről: 2019. 10. 19. – 2019. 11. 06.
o 4.3 Tesztelési dokumentum: 2019. 10. 29. – 2019. 11. 05.
o 4.4 Bemutató: 2019. 11. 05. – 2019. 11. 05.
