import React from 'react'

import { myClientList, selectCreating, selectClient, selectEditing } from '../redux/client/client.selectors'
import { addClient, editClient, fetchClients, removeClient, startCreate, stopCreate, startEdit, stopEdit } from '../redux/client/client.actions'

import AuthContext from '../context/auth-context'
import { connect } from 'react-redux'

import ClientList from '../components/Clients/ClientList/ClientList'
import ClientDetails from '../components/Clients/ClientDetails/ClientDetails'
import Modal from '../components/Modal/Modal'
import Backdrop from '../components/Backdrop/Backdrop'

const mapStateToProps = state => ({
  clients: myClientList(state),
  isCreating: selectCreating(state),
  isEditing: selectEditing(state),
  selectedClient: selectClient(state)
})

const mapDispatchToProps = dispatch => ({
  addClient: newData => dispatch(addClient(newData)),
  editClient: newData => dispatch(editClient(newData)),
  fetchClients: options => dispatch(fetchClients(options)),
  removeClient: id => dispatch(removeClient(id)),
  startCreate: () => dispatch(startCreate()),
  stopCreate: () => dispatch(stopCreate()),
  startEdit: id => dispatch(startEdit(id)),
  stopEdit: () => dispatch(stopEdit())
})

class ClientPage extends React.Component {
  static contextType = AuthContext

  constructor(props) {
    super(props)
    this.nameEl = React.createRef()
    this.addressEl = React.createRef()
    this.phoneEl = React.createRef()
    this.emailEl = React.createRef()
  }

  addClient = () => {

  }

  componentDidMount() {
    this.props.fetchClients({ creatorid: this.context.userId })
  }

  render() {
    return (
      <div>
        {this.props.isCreating || this.props.isEditing && <Backdrop />}
        {
          this.props.isCreating &&
          <Modal
            tite="Add Client"
            canCancel
            canConfirm
            onCancel={this.props.stopCreate}
            onConfirm={this.addClient}
            confirmText="Add Client"
          >
            <form>
              <div className="form-control">
                <label htmlFor="clientname">Client Name</label>
                <input type="text" id="firstname" ref={this.nameEl} required />

                <label htmlFor="clientphone">Client Phone</label>
                <input type="phone" id="clientphone" ref={this.phoneEl} required />
              </div>
              <div className="form-control">
                <label htmlFor="email">Client Email</label>
                <input type="email" id="email" ref={this.emailEl} required />
              </div>
              <div className="form-control">
                <label htmlFor="lastname">Client Address</label>
                <input type="phone" id="phone" ref={this.addressEl} required />
              </div>
            </form>
          </Modal>
        }
        <h1>Clients</h1>
        <button onClick={this.props.startCreate}>Add Client</button>
        {this.props.selectedClient && <ClientDetails />}
        {!this.props.selectedClient && this.props.clients && <ClientList clients={this.props.clients} />}
        {!this.props.selectedClient && !this.props.clients && <h2>No Clients Found, Feel Free To Add One</h2>}
      </div>
    )
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(ClientPage)

// needs the client and project and contact selectors

