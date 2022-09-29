describe("Jika membuka maka akan ke laman siakad", () => {
    it("Can be open and see the data", () => {
     cy.visit("http://127.0.0.1:8000/mahasiswa");
     cy.get("h2").should("have.text","JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG");
    })


    it("user can input mahasiswa",()=>{
        cy.visit("http://127.0.0.1:8000/mahasiswa/create");
    });
  })