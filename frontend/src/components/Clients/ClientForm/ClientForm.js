import React, { useState } from 'react'
import connect from 'react-redux'

const clientForm = ({ dispatch }) => {
  const [name, setName] = useState('')
  const [address, setAddress] = useState('');
  const [phone, setPhone] = useState('');
  const [email, setEmail] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault()
    const newClient = {
      name,
      address,
      phone,
      email
    }

    dispatch(addClient(newClient))
    setName('')
    setAddress('')
    setPhone('')
    setEmail('')
  }

  return (
    <form onSubmit={handleSubmit}>
      <input type="text" placeholder="Client Name" value={name} onChange={e => setName(e.target.value)} required />
      <input type="email" placeholder="Client Email" value={email} onChange={e => setEmail(e.target.value)} required />
      <input type="text" placeholder="Client Phone" value={phone} onChange={e => setPhone(e.target.value)} />
      <input type="text" placeholder="Client Address" value={address} onChange={e => setAddress(e.target.value)} />
    </form>
  )
}

export default connect(null)(clientForm)