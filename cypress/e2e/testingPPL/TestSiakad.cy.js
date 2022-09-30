describe('User can open the dashboard of SIAKAD', () => {
    it('Index Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get('h2').should('have.text','JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG');
    });
  
  //Create
    it('Can Create Data', () => {
      cy.visit("http://127.0.0.1:8000/mahasiswa")
      cy.get('.btn-success').click();
      cy.get('#Nim').type("204172040")
      cy.get('#Nama').type("Al Husein")
      cy.get('#Email').type("Alhusein@gmail.com")
      cy.get('#Alamat').type("Tulungagung")
      cy.get('#Tanggal_Lahir').type("2001-03-28")
      cy.get('#Jurusan').type("Teknologi Informasi")
      cy.get('#Jenis_Kelamin').type("L")
      cy.get(':nth-child(10) > .form-control').selectFile('Alhusein.jpg')
      cy.get('.btn').contains("Submit").and("be.enabled");
      cy.visit("http://127.0.0.1:8000/mahasiswa")
    })

  //Read
    it('Show Mahasiswa List', () => {
        cy.visit("http://127.0.0.1:8000/mahasiswa");
        cy.get(':nth-child(10) > .btn-info').click();
        cy.get('.card-header').contains('Detail Mahasiswa').and('be.visible');
        cy.get('.list-group > :nth-child(1)').contains('Nim: 2041720049').and('be.visible');
        cy.get('.list-group > :nth-child(2)').contains('Nama: Isaac Newton').and('be.visible');
        cy.get('.list-group > :nth-child(3)').contains('Email: citacoy@gmail.com').and('be.visible');
        cy.get('.btn').click();
    })

  // Update
    it('Can Edit Data', () => {
      cy.visit("http://127.0.0.1:8000/mahasiswa")
      cy.get(':nth-child(10) > .btn-primary').click();
      cy.get('#Nim').type("204172040")
      cy.get('#Nama').type("Al Husein")
      cy.get('#Email').type("Alhusein@gmail.com")
      cy.get('#Alamat').type("Tulungagung")
      cy.get('#Tanggal_Lahir').type("2001-03-28")
      cy.get('#Jurusan').type("Teknologi Informasi")
      cy.get('#Jenis_Kelamin').type("L")
      cy.get(':nth-child(11) > .form-control').selectFile('Alhusein.jpg')
      cy.get('.btn').contains("Submit").and("be.enabled");
      cy.visit("http://127.0.0.1:8000/mahasiswa")
    })

  //Delete
    it('Delete Mahasiswa List', () => {
      cy.visit("http://127.0.0.1:8000/mahasiswa");
      cy.get(':nth-child(10) > .btn-danger').click();
    });

})