$(document).ready(function(){

    // Defining the local dataset
    var cities = ['Athens', 'Thessaloniki', 'Patras', 'Piraeus', 'Larissa', 'Heraklion', 'Peristeri', 'Kallithea',
    'Acharnes','Kalamaria', 'Nikaia', 'Glyfada', 'Volos', 'Ilio', 'Ilioupoli', 'Keratsini', 'Evosmos', 'Chalandri',
    'Nea Smyrni', 'Marousi', 'Agios Dimitrios', 'Zografou', 'Egaleo', 'Nea Ionia', 'Ioannina', 'Palaio Faliro', 
    'Korydallos', 'Trikala', 'Vyronas', 'Agia Paraskevi', 'Galatsi', 'Agrinio', 'Chalcis', 'Petroupoli', 'Serres',
    'Alexandroupoli', 'Xanthi', 'Katerini', 'Kalamata', 'Kavala', 'Chania', 'Lamia', 'Komotini', 'Irakleio', 'Rhodes',
    'Kifissia', 'Stavroupoli', 'Chaidari', 'Drama', 'Veria', 'Alimos', 'Kozani', 'Polichni', 'Polichni', 'Karditsa',
    'Sykies', 'Ampelokipoi', 'Pylaia', 'Agioi Anargyroi', 'Argyroupoli', 'Ano Liosia', 'Nea Ionia', 'Rethymno', 'Ptolemaida', 
    'Tripoli', 'Cholargos', 'Vrilissia', 'Aspropyrgos', 'Corinth', 'Gerakas', 'Metamorfosi', 'Giannitsa', 'Voula', 'Kamatero',
    'Mytilene', 'Neapoli', 'Eleftherio-Kordelio', 'Chios', 'Agia Varvara', 'Kaisariani', 'Nea Filadelfeia', 'Moschato', 'Perama',
    'Salamina', 'Eleusis', 'Corfu', 'Pyrgos', 'Megara', 'Kilkis', 'Dafni', 'Thebes', 'Melissia', 'Argos', 'Arta', 'Artemida',
    'Livadeia', 'Pefki', 'Oraiokastro', 'Aigio', 'Kos', 'Koropi', 'Preveza', 'Naousa', 'Orestiada', 'Peraia', 'Edessa', 'Florina',
    'Panorama', 'Nea Erythraia', 'Elliniko', 'Amaliada', 'Pallini', 'Sparta', 'Agios Ioannis Rentis', 'Thermi', 'Vari', 'Nea Makri',
    'Tavros', 'Alexandreia', 'Menemeni', 'Paiania', 'Kalyvia Thorikou', 'Nafplio', 'Drapetsona', 'Efkarpia', 'Papagou', 'Nafpaktos',
    'Kastoria', 'Grevena', 'Pefka', 'Nea Alikarnassos', 'Missolonghi', 'Gazi', 'Ierapetra', 'Kalymnos', 'Rafina', 'Loutraki', 
    'Agios Nikolaos', 'Ermoupoli', 'Ialysos', 'Mandra', 'Tyrnavos', 'Glyka Nera', 'Ymittos', 'Neo Psychiko'
    ];
    
    // Constructing the suggestion engine
    var cities = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: cities
    });
    
    // Initializing the typeahead
    $('.typeahead').typeahead({
        hint: true,
        highlight: true, /* Enable substring highlighting */
        minLength: 1 /* Specify minimum characters required for showing result */
    },
    {
        name: 'cities',
        source: cities
    });
});