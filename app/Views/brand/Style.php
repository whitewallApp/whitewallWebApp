import { StyleSheet } from "react-native";

const styles = StyleSheet.create({
    //background
    background: {
        flex: 1,
        padding: 24,
        backgroundColor: "<?= array_key_exists("color", $branding["background"]) ? ($branding["background"]["color"]):("white") ?>",
    },
    dropdown_background: {
        padding: 5,
        backgroundColor: "<?= array_key_exists("color", $branding["background"]) ? ($branding["background"]["color"]):("white") ?>"
    },

    //categories
    tabStyle: {
        backgroundColor: "<?= array_key_exists("backgroundcolor", $branding["categories"]) ? ($branding["categories"]["backgroundcolor"]):("white") ?>",
        activeColor: "lightgray",
        inactiveColor: "black",
    },

    //call to action
    action: {
        fontSize: 10, 
        textAlign: 'center',
        color: "<?= array_key_exists("actionColor", $branding) ? ($branding["actionColor"]):("white") ?>"
    },

    //loading Image
    loading: {
        flex: 1,
        width: "<?= array_key_exists("headerSize", $branding) ? ($branding["headerSize"]):("100") ?>%",
        alignSelf: "center"
    },

    //header
    header: {
        flex: 1,
        //branding
        width: "<?= array_key_exists("size", $branding["loading"]) ? ($branding["loading"]["size"]):("100") ?>%",
        alignSelf: "center"
    },

    header_container: { 
        width: "100%", 
        height: "auto", 
        flex: 0.2,
        
        //branding
        backgroundColor: "<?= array_key_exists("color", $branding["background"]) ? ($branding["background"]["color"]):("white") ?>"
    },
    
    //
    card: {
        margin: 10,
        padding: 10,
        flex: 1,
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",

        //branding border
        borderWidth: <?= array_key_exists("borderWidth", $branding["cards"]["frames"]) ? ($branding["cards"]["frames"]["borderWidth"]):(0) ?>,
        borderColor: "<?= array_key_exists("borderColor", $branding["cards"]["frames"]) ? ($branding["cards"]["frames"]["borderColor"]):("white") ?>",
        borderRadius: <?= array_key_exists("borderRadius", $branding["cards"]["frames"]) ? ($branding["cards"]["frames"]["borderRadius"]):(0) ?>,
        backgroundColor: "<?= array_key_exists("backgroundcolor", $branding["cards"]) ? ($branding["cards"]["backgroundcolor"]):("white") ?>"
    },

    card_label: {
        width: 150,
        flex: 1,
        flexWrap: "wrap",
        textAlign: "center",

        //branding
        fontSize: <?= array_key_exists("fontsize", $branding["cards"]) ? ($branding["cards"]["fontsize"]):(15) ?>,
        fontFamily: "<?= array_key_exists("font", $branding["cards"]) ? ($branding["cards"]["font"]):("normal") ?>",
        fontWeight: "normal",
        fontStyle: "normal",
        color: "<?= array_key_exists("fontcolor", $branding["cards"]) ? ($branding["cards"]["fontcolor"]):("black") ?>"
    },

    card_images: {
        width: 150,
        height: 190,

        //branding
        borderWidth: <?= array_key_exists("borderWidth", $branding["cards"]["images"]) ? ($branding["cards"]["images"]["borderWidth"]):(0) ?>,
        borderColor: "<?= array_key_exists("borderColor", $branding["cards"]["images"]) ? ($branding["cards"]["images"]["borderColor"]):("black") ?>",
        borderRadius: <?= array_key_exists("borderRadius", $branding["cards"]["images"]) ? ($branding["cards"]["images"]["borderRadius"]):(10) ?>,
    },

    button: {
        width: "95%",
        height: 40,
        flex: 1,
        margin: 5,
        alignItems: "center", 
        justifyContent: 'center',

        //branding
        backgroundColor: "<?= array_key_exists("borderColor", $branding["buttons"]) ? ($branding["buttons"]["borderColor"]):("#03a5fc") ?>",
        borderRadius: <?= array_key_exists("borderRadius", $branding["buttons"]) ? ($branding["buttons"]["borderRadius"]):(10) ?>,
    },

    button_text: {
        //branding
        color: "<?= array_key_exists("fontcolor", $branding["buttons"]) ? ($branding["buttons"]["fontcolor"]):("white") ?>",
        fontSize: <?= array_key_exists("fontsize", $branding["buttons"]) ? ($branding["buttons"]["fontsize"] * 2):(30) ?>,
        fontFamily: "<?= array_key_exists("font", $branding["buttons"]) ? ($branding["buttons"]["font"]):("normal") ?>",
        fontStyle: "normal",
        fontWeight: "normal"
    },

    wallpaper_image: {
        width: "100%",
        height: "100%",
        flex: 1,
        alignItems: "center",
        justifyContent: 'center',
    },

    dropdown1BtnStyle: {
        width: '80%',
        height: 50,
        backgroundColor: '<?= array_key_exists("backgroundcolor", $branding["dropdowns"]) ? ($branding["dropdowns"]["backgroundcolor"]):("#FFF") ?>',
        borderRadius: 8,
        borderWidth: 1,
        borderColor: '#444',
    },
    dropdown1BtnTxtStyle: { color: '<?= array_key_exists("fontcolor", $branding["dropdowns"]) ? ($branding["dropdowns"]["fontcolor"]):("#444") ?>', textAlign: 'left' },
    dropdown1DropdownStyle: { backgroundColor: '#EFEFEF', borderRadius: 8 },
    dropdown1RowStyle: { backgroundColor: '#EFEFEF', borderBottomColor: '#C5C5C5' },
    dropdown1RowTxtStyle: { color: '<?= array_key_exists("fontcolor", $branding["dropdowns"]) ? ($branding["dropdowns"]["fontcolor"]):("#444") ?>', textAlign: 'left' },
});

export default styles;