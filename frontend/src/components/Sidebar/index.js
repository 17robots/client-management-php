export default class Sidebar extends React.Component {
  constructor(props) {
    super(props)
  }

  goHome = () => {
    props.browserHistory.push('/')
  }

  goClients = () => {
    props.browserHistory.push('/clients')
  }

  goProjects = () => {
    props.browserHistory.push('/projects')
  }

  render() {
    return (
      <div className="sidebar">
        <button className="sidebar__tab" onClick={this.goHome} value="Home" />
        <button className="sidebar__tab" onClick={this.goClients} value="Clients" />
        <button className="sidebar__tab" onClick={this.goProjects} value="Projects" />
      </div>
    )
  }
}
