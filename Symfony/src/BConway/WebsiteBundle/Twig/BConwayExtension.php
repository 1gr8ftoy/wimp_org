<?php
// src/BConway/WebsiteBundle/Twig/BConwayExtension.php
namespace BConway\WebsiteBundle\Twig;

class BConwayExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('encodeEmail', array($this, 'encodedMailToFilter'), array('is_safe' => array('html')))
        );

    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('stateSelect', array($this, 'stateSelectFunction'))
        );
    }

    public function encodedMailToFilter($emailAddress)
    {
        $output = '';
        for ($i = 0; $i < strlen($emailAddress); $i++) { $output .= '&#'.ord($emailAddress[$i]).';'; }
        return 'mailto:' . $output;
    }

    public function stateSelectFunction($selectedState = true, $showFullStateName = null)
    {
        $html = '';
        $html .= '<select name="state" size="1">';
        $html .= '<option>';
        $html .= 'Any/All';
        $html .= '</option>';
        $html .= '<option value="AK"' . (($selectedState === 'AK') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Alabama' : 'AK';
        $html .= '</option>';
        $html .= '<option value="AL"' . (($selectedState === 'AL') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Alaska' : 'AL';
        $html .= '</option>';
        $html .= '<option value="AR"' . (($selectedState === 'AR') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Arizona' : 'AR';
        $html .= '</option>';
        $html .= '<option value="AZ"' . (($selectedState === 'AZ') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Arkansas' : 'AZ';
        $html .= '</option>';
        $html .= '<option value="CA"' . (($selectedState === 'CA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'California' : 'CA';
        $html .= '</option>';
        $html .= '<option value="CO"' . (($selectedState === 'CO') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Colorado' : 'CO';
        $html .= '</option>';
        $html .= '<option value="CT"' . (($selectedState === 'CT') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Connecticut' : 'CT';
        $html .= '</option>';
        $html .= '<option value="DC"' . (($selectedState === 'DC') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Delaware' : 'DC';
        $html .= '</option>';
        $html .= '<option value="DE"' . (($selectedState === 'DE') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'District of Columbia' : 'DE';
        $html .= '</option>';
        $html .= '<option value="FL"' . (($selectedState === 'FL') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Florida' : 'FL';
        $html .= '</option>';
        $html .= '<option value="GA"' . (($selectedState === 'GA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Georgia' : 'GA';
        $html .= '</option>';
        $html .= '<option value="HI"' . (($selectedState === 'HI') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Hawaii' : 'HI';
        $html .= '</option>';
        $html .= '<option value="IA"' . (($selectedState === 'IA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Idaho' : 'IA';
        $html .= '</option>';
        $html .= '<option value="ID"' . (($selectedState === 'ID') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Illinois' : 'ID';
        $html .= '</option>';
        $html .= '<option value="IL"' . (($selectedState === 'IL') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Indiana' : 'IL';
        $html .= '</option>';
        $html .= '<option value="IN"' . (($selectedState === 'IN') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Iowa' : 'IN';
        $html .= '</option>';
        $html .= '<option value="KS"' . (($selectedState === 'KS') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Kansas' : 'KS';
        $html .= '</option>';
        $html .= '<option value="KY"' . (($selectedState === 'KY') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Kentucky' : 'KY';
        $html .= '</option>';
        $html .= '<option value="LA"' . (($selectedState === 'LA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Louisiana' : 'LA';
        $html .= '</option>';
        $html .= '<option value="MA"' . (($selectedState === 'MA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Maine' : 'MA';
        $html .= '</option>';
        $html .= '<option value="MD"' . (($selectedState === 'MD') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Maryland' : 'MD';
        $html .= '</option>';
        $html .= '<option value="ME"' . (($selectedState === 'ME') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Massachusetts' : 'ME';
        $html .= '</option>';
        $html .= '<option value="MI"' . (($selectedState === 'MI') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Michigan' : 'MI';
        $html .= '</option>';
        $html .= '<option value="MN"' . (($selectedState === 'MN') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Minnesota' : 'MN';
        $html .= '</option>';
        $html .= '<option value="MO"' . (($selectedState === 'MO') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Mississippi' : 'MO';
        $html .= '</option>';
        $html .= '<option value="MS"' . (($selectedState === 'MS') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Missouri' : 'MS';
        $html .= '</option>';
        $html .= '<option value="MT"' . (($selectedState === 'MT') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Montana' : 'MT';
        $html .= '</option>';
        $html .= '<option value="NC"' . (($selectedState === 'NC') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Nebraska' : 'NC';
        $html .= '</option>';
        $html .= '<option value="ND"' . (($selectedState === 'ND') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Nevada' : 'ND';
        $html .= '</option>';
        $html .= '<option value="NE"' . (($selectedState === 'NE') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'New Hampshire' : 'NE';
        $html .= '</option>';
        $html .= '<option value="NH"' . (($selectedState === 'NH') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'New Jersey' : 'NH';
        $html .= '</option>';
        $html .= '<option value="NJ"' . (($selectedState === 'NJ') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'New Mexico' : 'NJ';
        $html .= '</option>';
        $html .= '<option value="NM"' . (($selectedState === 'NM') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'New York' : 'NM';
        $html .= '</option>';
        $html .= '<option value="NV"' . (($selectedState === 'NV') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'North Carolina' : 'NV';
        $html .= '</option>';
        $html .= '<option value="NY"' . (($selectedState === 'NY') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'North Dakota' : 'NY';
        $html .= '</option>';
        $html .= '<option value="OH"' . (($selectedState === 'OH') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Ohio' : 'OH';
        $html .= '</option>';
        $html .= '<option value="OK"' . (($selectedState === 'OK') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Oklahoma' : 'OK';
        $html .= '</option>';
        $html .= '<option value="OR"' . (($selectedState === 'OR') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Oregon' : 'OR';
        $html .= '</option>';
        $html .= '<option value="PA"' . (($selectedState === 'PA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Pennsylvania' : 'PA';
        $html .= '</option>';
        $html .= '<option value="RI"' . (($selectedState === 'RI') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Rhode Island' : 'RI';
        $html .= '</option>';
        $html .= '<option value="SC"' . (($selectedState === 'SC') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'South Carolina' : 'SC';
        $html .= '</option>';
        $html .= '<option value="SD"' . (($selectedState === 'SD') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'South Dakota' : 'SD';
        $html .= '</option>';
        $html .= '<option value="TN"' . (($selectedState === 'TN') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Tennessee' : 'TN';
        $html .= '</option>';
        $html .= '<option value="TX"' . (($selectedState === 'TX') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Texas' : 'TX';
        $html .= '</option>';
        $html .= '<option value="UT"' . (($selectedState === 'UT') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Utah' : 'UT';
        $html .= '</option>';
        $html .= '<option value="VA"' . (($selectedState === 'VA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Vermont' : 'VA';
        $html .= '</option>';
        $html .= '<option value="VT"' . (($selectedState === 'VT') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Virginia' : 'VT';
        $html .= '</option>';
        $html .= '<option value="WA"' . (($selectedState === 'WA') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Washington' : 'WA';
        $html .= '</option>';
        $html .= '<option value="WI"' . (($selectedState === 'WI') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'West Virginia' : 'WI';
        $html .= '</option>';
        $html .= '<option value="WV"' . (($selectedState === 'WV') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Wisconsin' : 'WV';
        $html .= '</option>';
        $html .= '<option value="WY"' . (($selectedState === 'WY') ? ' selected' : '') . '>';
        $html .= ($showFullStateName) ? 'Wyoming' : 'WY';
        $html .= '</option>';
        $html .= '</select>';

        echo $html;
    }

    public function getName()
    {
        return 'bconway_extension';
    }
}