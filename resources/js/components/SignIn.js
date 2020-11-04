import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class SignIn extends Component {
    render() {
        return (
            <div>
              <div className="form-group">
                  <input name="username" type="text" placeholder="Username" className="form-control" autoFocus required />
              </div>
              <div className="form-group">
                  <input name="password" type="password" className="form-control" placeholder="Password" required />
              </div>
              <button type="submit" className="btn btn-primary block full-width m-b">Login</button>
            </div>
        );
    }
}

if (document.getElementById('signIn')) {
    ReactDOM.render(<SignIn />, document.getElementById('signIn'));
}
