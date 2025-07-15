/**
 * @jest-environment jsdom
 */

describe('Basic Project Setup', () => {
  it('should pass basic test', () => {
    expect(1 + 1).toBe(2)
  })

  it('should have correct environment', () => {
    expect(process.env.NODE_ENV).toBeDefined()
  })
})
