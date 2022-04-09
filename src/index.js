import { render, Component } from "@wordpress/element";
import Data from "./components/Data";

class App extends Component {
  render() {
    return (
      <>
        <h2>Quiz Marking System</h2>
        <Data />
      </>
    );
  }
}

render(<App />, document.getElementById("react-app"));
