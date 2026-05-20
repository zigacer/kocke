# 🎰 Grand Casino – PHP Dice Game

## 📌 Opis projekta
**Grand Casino** je preprosta spletna igra v PHP, kjer se trije igralci pomerijo v metanju kock skozi več rund.  
Projekt uporablja **PHP**, **HTML**, **CSS** in **JavaScript** za prikaz igre, animacij ter rezultatov.

Igralci vnesejo svoja uporabniška imena, določijo število rund in število kock, nato pa sistem samodejno generira mete ter izračuna skupne točke.

---

## 🚀 Funkcionalnosti

- Registracija 3 igralcev
- Nastavitev:
  - števila rund (1–3)
  - števila kock (1–3)
- Naključni meti kock (`rand(1,6)`)
- Animacija vrtenja kock
- Samodejno seštevanje rezultatov
- Prikaz zmagovalca na stopničkah 🥇🥈🥉
- Konfeti ob zaključku igre

---

## 🛠️ Uporabljene tehnologije

- **PHP**
- **HTML5**
- **CSS3**
- **JavaScript**

---

## 🎲 Delovanje igre

Igra poteka skozi več rund.  
Vsak igralec v posamezni rundi vrže izbrano število kock, sistem pa:
- naključno generira rezultate,
- prikaže animacijo vrtenja,
- izračuna točke,
- posodobi skupni rezultat igralca.

Primer generiranja meta:

```php
$met = rand(1, 6);
```

Za razvrščanje igralcev po številu točk se uporablja:

```php
arsort($sestevki);
```

---

## 📚 Glavni koncepti v projektu

- Delo z obrazci (`POST`)
- Naključna števila
- Dinamični HTML z PHP
- JavaScript animacije
- Razvrščanje rezultatov
- Responsive design

---

## 👨‍💻 Avtor

Žiga Černe Bralić

