import React from 'react';
import Router from './navigation/Router'

export default class App extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      check: true,
      login: false
    }
  }

  handleCheck = (check) => {
    this.setState({check : !check})
  }
  render() {
    return (

    
        <Router/>
        // <ChangePassword/>
    )

  }
}
