<div id="smc"></div>

<div id="lister" style="font-size: large; float: right;">
    <a href="/show/listing/fan_temps/smc" title="List">
        <i class="btn btn-default tab-btn fa fa-list"></i>
    </a>
</div>
<h2><i class="fa fa-microchip"></i> <span data-i18n="fan_temps.tabtitle_smc"></span></h2>

<div id="smc-msg" data-i18n="listing.loading" class="col-lg-12 text-center"></div>

<!--All the brains of this tab are a part of the amps_tab-->

<script>
$(document).on('appReady', function(){
    // Function to get language flag emoji from keyboard language description
    function getLanguageFlag(keyboardLanguage) {
        if (!keyboardLanguage) return '';
        
        // Map keyboard language descriptions to country codes for flags
        const keyboardToCountry = {
            // English
            'U.S.': 'US',
            'US': 'US',
            'USA': 'US',
            'American': 'US',
            'British': 'GB',
            'UK': 'GB',
            'Australian': 'AU',
            'Canadian': 'CA',
            'Canadian English': 'CA',
            'Irish': 'IE',
            
            // European
            'Spanish': 'ES',
            'Spanish - ISO': 'ES',
            'Russian': 'RU',
            'Hebrew': 'IL',
            'German': 'DE',
            'Dutch': 'NL',
            'French': 'FR',
            'French - ISO': 'FR',
            'French - numerical': 'FR',
            'Italian': 'IT',
            'Italian - Pro': 'IT',
            'Norwegian': 'NO',
            'Swedish': 'SE',
            'Swedish - Pro': 'SE',
            'Swiss': 'CH',
            'Swiss French': 'CH',
            'Swiss German': 'CH',
            'Belgian': 'BE',
            'Portuguese': 'PT',
            'Portuguese - ISO': 'PT',
            'Danish': 'DK',
            'Finnish': 'FI',
            'Hungarian': 'HU',
            'Icelandic': 'IS',
            'Polish': 'PL',
            'Polish Pro': 'PL',
            'Czech': 'CZ',
            'Slovak': 'SK',
            'Croatian': 'HR',
            'Romanian': 'RO',
            'Turkish': 'TR',
            'Turkish-Q': 'TR',
            'Greek': 'GR',
            'Croatian': 'HR',
            
            // Asian
            'Japanese': 'JP',
            'Japanese Keyboard': 'JP',
            'Korean': 'KR',
            'Chinese': 'CN',
            'Simplified Chinese': 'CN',
            'Simplified Chinese Keyboard': 'CN',
            'Traditional Chinese': 'TW',
            
            // Middle Eastern
            'Arabic': 'SA',
            'Persian': 'IR',
            
            // India
            'Hindi': 'IN',
            'Thai': 'TH',
            'Vietnamese': 'VN'
        };
        
        // Try to match based on the full string first
        let countryCode = keyboardToCountry[keyboardLanguage];
        
        // If not found, try to extract primary language from the string
        if (!countryCode) {
            // Try to match based on the first word
            const firstWord = keyboardLanguage.split(' ')[0].split('-')[0];
            countryCode = keyboardToCountry[firstWord];
            
            if (!countryCode) {
                // If still no match, search within the string for keywords
                for (const key in keyboardToCountry) {
                    if (keyboardLanguage.toLowerCase().includes(key.toLowerCase())) {
                        countryCode = keyboardToCountry[key];
                        break;
                    }
                }
            }
        }
        
        // Default to question mark if no match found
        if (!countryCode) {
            return '❓';
        }
        
        // Convert country code to regional indicator symbols
        const offset = 127397; // Regional indicator symbols start at this offset
        const flag = countryCode.toUpperCase()
            .split('')
            .map(char => String.fromCodePoint(char.charCodeAt(0) + offset))
            .join('');
        return flag;
    }
    
    // Make the original function available globally for use in amps_tab
    window.getKeyboardLanguageFlag = getLanguageFlag;
    
    // This flag will be rendered in the data rows by the amps_tab script
});
</script>
