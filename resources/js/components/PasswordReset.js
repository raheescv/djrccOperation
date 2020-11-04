import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class PasswordReset extends Component {
    render() {
        return (
            <div>
              <div className="form-group">
                  <input name="password" type="password" placeholder="Password" className="form-control" autoFocus required />
              </div>
              <div className="form-group">
                  <input name="password_confirmation" type="password" className="form-control" placeholder="Confirm Password" required />
              </div>
              <button type="submit" className="btn btn-primary block full-width m-b">Login</button>
            </div>
        );
    }
}

if (document.getElementById('PasswordReset')) {
    ReactDOM.render(<PasswordReset />, document.getElementById('PasswordReset'));
}
