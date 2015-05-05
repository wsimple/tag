<?php

namespace Faker\Provider\es_MX;

class Address extends \Faker\Provider\Address
{
    protected static $cityPrefix = array('Sur', 'Norte',);
    protected static $citySuffix = array('de la Montaña', 'los bajos', 'los altos',);
    protected static $buildingNumber = array('###', '##', '#');
    protected static $streetPrefix = array(
        'Ampliación', 'Andador', 'Avenida', 'Boulevard', 'Calle', 'Callejón',
        'Calzada', 'Cerrada', 'Circuito', 'Circunvalación', 'Continuación',
        'Corredor', 'Diagonal', 'Eje vial', 'Pasaje', 'Peatonal', 'Periférico',
        'Privada', 'Prolongación', 'Retorno', 'Viaducto'
        );
    protected static $streetSuffix = array('Norte', 'Este', ' Sur', ' Oeste');
    protected static $postcode = array('####');
    protected static $state = array(
        'Aguascalientes',
        'Baja California',
        'Baja California Sur',
        'Campeche',
        'Coahuila de Zaragoza', 'Colima',
        'Chiapas', 
        'Chihuahua',
        'Distrito Federal',
        'Durango',
        'Guanajuato', 'Guerrero', 'Hidalgo',
        'Jalisco', 'México',
        'Michoacán de Ocampo', 'Morelos',
        'Nayarit', 'Nuevo León', 'Oaxaca',
        'Puebla', 'Querétaro',
        'Quintana Roo', 'San Luis Potosí',
        'Sinaloa', 'Sonora', 'Tabasco',
        'Tamaulipas', 'Tlaxcala',
        'Veracruz de Ignacio de la Llave',
        'Yucatán', 
        'Zacatecas',);
    protected static $country = array(
        'Afganistán', 'Albania', 'Alemania', 'Andorra', 'Angola', 'Antigua y Barbuda', 'Arabia Saudí', 'Argelia', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaiyán',
        'Bahamas', 'Bangladés', 'Barbados', 'Baréin', 'Belice', 'Benín', 'Bielorrusia', 'Birmania', 'Bolivia', 'Bosnia-Herzegovina', 'Botsuana', 'Brasil', 'Brunéi Darusalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Bután', 'Bélgica',
        'Cabo Verde', 'Camboya', 'Camerún', 'Canadá', 'Catar', 'Chad', 'Chile', 'China', 'Chipre', 'Ciudad del Vaticano', 'Colombia', 'Comoras', 'Congo', 'Corea del Norte', 'Corea del Sur', 'Costa Rica', 'Costa de Marfil', 'Croacia', 'Cuba',
        'Dinamarca', 'Dominica',
        'Ecuador', 'Egipto', 'El Salvador', 'Emiratos Árabes Unidos', 'Eritrea', 'Eslovaquia', 'Eslovenia', 'España', 'Estados Unidos de América', 'Estonia', 'Etiopía',
        'Filipinas', 'Finlandia', 'Fiyi', 'Francia',
        'Gabón', 'Gambia', 'Georgia', 'Ghana', 'Granada', 'Grecia', 'Guatemala', 'Guinea', 'Guinea Ecuatorial', 'Guinea-Bisáu', 'Guyana',
        'Haití', 'Honduras', 'Hungría',
        'India', 'Indonesia', 'Irak', 'Irlanda', 'Irán', 'Islandia', 'Islas Marshall', 'Islas Salomón', 'Israel', 'Italia',
        'Jamaica', 'Japón', 'Jordania',
        'Kazajistán', 'Kenia', 'Kirguistán', 'Kiribati', 'Kuwait',
        'Laos', 'Lesoto', 'Letonia', 'Liberia', 'Libia', 'Liechtenstein', 'Lituania', 'Luxemburgo', 'Líbano',
        'Macedonia', 'Madagascar', 'Malasia', 'Malaui', 'Maldivas', 'Mali', 'Malta', 'Marruecos', 'Mauricio', 'Mauritania', 'Micronesia', 'Moldavia', 'Mongolia', 'Montenegro', 'Mozambique', 'México', 'Mónaco',
        'Namibia', 'Nauru', 'Nepal', 'Nicaragua', 'Nigeria', 'Noruega', 'Nueva Zelanda', 'Níger',
        'Omán',
        'Pakistán', 'Palaos', 'Panamá', 'Papúa Nueva Guinea', 'Paraguay', 'Países Bajos', 'Perú', 'Polonia', 'Portugal',
        'Reino Unido', 'Reino Unido de Gran Bretaña e Irlanda del Norte', 'República Centroafricana', 'República Checa', 'República Democrática del Congo', 'República Dominicana', 'Ruanda', 'Rumanía', 'Rusia',
        'Samoa', 'San Cristóbal y Nieves', 'San Marino', 'San Vicente y las Granadinas', 'Santa Lucía', 'Santo Tomé y Príncipe', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leona', 'Singapur', 'Siria', 'Somalia', 'Sri Lanka', 'Suazilandia', 'Sudáfrica', 'Sudán', 'Suecia', 'Suiza', 'Surinam',
        'Tailandia', 'Tanzania', 'Tayikistán', 'Timor Oriental', 'Togo', 'Tonga', 'Trinidad y Tobago', 'Turkmenistán', 'Turquía', 'Tuvalu', 'Túnez',
        'Ucrania', 'Uganda', 'Uruguay', 'Uzbekistán',
        'Vanuatu', 'Venezuela', 'Vietnam',
        'Yemen', 'Yibuti',
        'Zambia', 'Zimbabue'
    );
    protected static $cityFormats = array(
        '{{cityPrefix}} {{firstName}}{{citySuffix}}',
        '{{cityPrefix}} {{firstName}}',
        '{{firstName}} {{citySuffix}}',
        '{{lastName}} {{citySuffix}}',
    );
    protected static $streetNameFormats = array(
        '{{streetPrefix}} {{firstName}}',
        '{{streetPrefix}} {{lastName}}',
        '{{streetPrefix}} {{firstName}} {{lastName}}'
    );
    protected static $streetAddressFormats = array(
        '{{streetName}}, {{buildingNumber}}, {{secondaryAddress}}',
        '{{streetName}}, {{secondaryAddress}}',
    );
    protected static $addressFormats = array(
        "{{streetAddress}}, {{city}} Edo. {{state}}",
        "{{streetAddress}}, {{city}} Edo. {{state}}, {{postcode}}"
    );
    protected static $secondaryAddressFormats = array('Nro #', 'Piso #', 'Casa #', 'Hab. #', 'Apto #', 'Nro ##', 'Piso ##', 'Casa ##', 'Hab. ##', 'Apto ##');

    /**
     * @example 'Avenida'
     */
    public static function streetPrefix()
    {
        return static::randomElement(static::$streetPrefix);
    }

    /**
     * @example 'Villa'
     */
    public static function cityPrefix()
    {
        return static::randomElement(static::$cityPrefix);
    }

    /**
     * @example 'Nro 3'
     */
    public static function secondaryAddress()
    {
        return static::numerify(static::randomElement(static::$secondaryAddressFormats));
    }

    /**
     * @example 'Aragua'
     */
    public static function state()
    {
        return static::randomElement(static::$state);
    }
}
