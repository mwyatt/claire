var dialogue = require('dialogue');

dialogue.create({
  positionTo: 'body',
  title: 'Foo Bar',
  description: 'Foo Bar.',
  actions: [
    {name: 'Cancel', action: function() {
      console.log('Cancel');
    }},
    {name: 'Ok', action: function() {
      console.log('Ok');
    }}
  ]
});
