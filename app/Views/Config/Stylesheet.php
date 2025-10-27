import { StyleSheet } from 'react-native';

export const styles = StyleSheet.create({
  // Background
  background: {
    backgroundColor: "<?= $background["color"] ?>" //branding.background.color
  },
  scollview: {
    flexDirection: "row",
    flexWrap: "wrap",
    padding: 8,
    justifyContent: 'space-between',
  },

  card: {
    flex: 1,
    borderRadius: <?= $cards["frames"]["borderRadius"] ?>,             //branding.cards.frames.borderRadius
    overflow: "hidden",
    padding: 5,
    alignItems: "center",
    backgroundColor: "<?= $cards["backgroundcolor"] ?>", //branding.cards.backgroundcolor,
    borderWidth: <?= $cards["frames"]["borderWidth"] ?>,               //branding.cards.frames.borderWidth
    borderColor: "<?= $cards["frames"]["borderColor"] ?>"      //branding.cards.frames.borderColor
  },
  card_title: {
    textAlign: "center",
    width: "100%",
    fontWeight: "<?= $cards["fontstyle"] ?>", //branding.cards.fontstyle
    fontSize: <?= $cards["fontsize"] ?>,         //branding.cards.fontsize
    color: "<?= $cards["fontcolor"] ?>",   //branding.cards.fontcolor
    fontStyle: "<?= $cards["fontstyle"] ?>",  //branding.cards.fontstyle
    fontFamily: "<?= $cards["font"] ?>", //branding.cards.font
  },
  card_img: {
    width: 180,
    borderRadius: <?= $cards["images"]["borderRadius"] ?>,     //branding.cards.images.borderRadius
    borderWidth: <?= $cards["images"]["borderWidth"] ?>,       //branding.cards.images.borderWidth
    borderColor: "<?= $cards["images"]["borderColor"] ?>"  //branding.cards.images.borderColor
  },
  cardWrapper: {
    width: "48%",
    marginBottom: 12,
  },

  //header stuff
  headerContainer: {
    width: "100%",
    height: 100,
    // paddingTop: 10,
    // paddingHorizontal: 15,
    // flexDirection: "row",
    // alignItems: "center",
    backgroundColor: "#bbb"
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: 'white',
  },
  backbutton: {
    color: "black"
  },
  header_img: {
    height: undefined,
    flex: 1,
    width: "100%",
    resizeMode: "contain",
    alignSelf: "center",
  },

  //button stuff
  button_text: {
    color: "<?= $buttons["fontcolor"] ?>",      //branding.buttons.fontcolor
    fontSize: <?= $buttons["fontsize"] ?>,        //branding.buttons.fontsize
    fontWeight: "<?= $buttons["fontstyle"] ?>",  //branding.buttons.fontstyle
    fontStyle: "<?= $buttons["fontstyle"] ?>",  //branding.buttons.fontstyle
    fontFamily: "<?= $buttons["font"] ?>", //branding.buttons.font
  },

  button: {
    height: 50,
    backgroundColor: "<?= $buttons["color"] ?>",   //branding.buttons.color
    borderRadius: <?= $buttons["borderRadius"] ?>,           //branding.buttons.borderRadius
    justifyContent: "center",
    alignItems: "center",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
    elevation: 5,
  },

  fab_button: {
    backgroundColor: "<?= $buttons["color"] ?>"
  }
});